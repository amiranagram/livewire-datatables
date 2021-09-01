<?php

namespace Amirami\LivewireDataTables;

use Amirami\LivewireDataTables\Contracts\ComputesProperties;
use Amirami\LivewireDataTables\Traits\InteractsWithDataTableTraits;
use Illuminate\Support\Str;
use Livewire\Component;

abstract class DataTable extends Component implements ComputesProperties
{
    use InteractsWithDataTableTraits;

    /**
     * @inheritDoc
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getEntriesProperty()
    {
        if ($this->hasLivewireDataTablesTrait('search')) {
            $this->applySearching($this->query);
        }

        if ($this->hasLivewireDataTablesTrait('sorting')) {
            $this->applySorting($this->query);
        }

        if ($this->hasLivewireDataTablesTrait('cached-rows')) {
            return $this->applyCaching(function () {
                return $this->getEntries();
            });
        }

        return $this->getEntries();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    protected function getEntries()
    {
        if ($this->hasLivewireDataTablesTrait('pagination')) {
            return $this->applyPagination($this->query);
        }

        return $this->query->get();
    }

    /**
     * @return array
     */
    public function getQueryString()
    {
        return collect($this->dataTableTraits ?? [])
            ->filter(function (string $trait) {
                return $this->isAmiramiLivewireDataTablesTrait($trait);
            })
            ->map(function ($trait) {
                $traitName = Str::of($trait)
                    ->explode('\\')
                    ->last();

                $callable = 'queryString' . $traitName;

                if (method_exists($this, $callable)) {
                    return $this->$callable();
                }

                if (property_exists($this, $callable)) {
                    return $this->$callable;
                }

                return [];
            })
            ->values()
            ->mapWithKeys(function ($value) {
                return $value;
            })
            ->merge(parent::getQueryString())
            ->toArray();
    }
}

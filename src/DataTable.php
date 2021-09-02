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
     */
    public function getEntriesProperty()
    {
        if ($this->isFeatureEnabled('searching')) {
            $this->applySearching($this->query);
        }

        if ($this->isFeatureEnabled('sorting')) {
            $this->applySorting($this->query);
        }

        if ($this->isFeatureEnabled('row-caching')) {
            return $this->applyRowCaching(function () {
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
        if ($this->isFeatureEnabled('pagination')) {
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
                return $this->isFirstPartyTrait($trait);
            })
            ->map(function ($trait) {
                $traitName = Str::of($trait)
                    ->explode('\\')
                    ->last();

                $callable = Str::studly('queryString' . $traitName);

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

<?php

namespace Amirami\LivewireDataTables;

use Amirami\LivewireDataTables\Traits\InteractsWithDataTableTraits;
use Illuminate\Support\Str;
use Livewire\Component;

abstract class DataTable extends Component
{
    use InteractsWithDataTableTraits;

    public const FEATURE_PAGINATION = 'pagination';
    public const FEATURE_SEARCHING = 'searching';
    public const FEATURE_SORTING = 'sorting';
    public const FEATURE_FILTERING = 'filtering';
    public const FEATURE_ROW_CACHING = 'row-caching';

    /**
     * Computed property to construct a query for paginator.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    abstract public function getQueryProperty();

    /**
     * Computed property to execute the paginator.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    public function getEntriesProperty()
    {
        if ($this->isFeatureEnabled(self::FEATURE_SEARCHING)) {
            $this->applySearching($this->query);
        }

        if ($this->isFeatureEnabled(self::FEATURE_SORTING)) {
            $this->applySorting($this->query);
        }

        if ($this->isFeatureEnabled(self::FEATURE_ROW_CACHING)) {
            return $this->applyRowCaching(function () {
                return $this->getEntries();
            });
        }

        return $this->getEntries();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    protected function getEntries()
    {
        if ($this->isFeatureEnabled(self::FEATURE_PAGINATION)) {
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
                $traitName = Str::afterLast($trait, '\\');
                $callable = 'queryString' . Str::studly($traitName);

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

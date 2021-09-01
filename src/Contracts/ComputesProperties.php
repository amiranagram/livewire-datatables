<?php

namespace Amirami\LivewireDataTables\Contracts;

/**
 * @property-read \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
 * @property-read \Illuminate\Contracts\Pagination\LengthAwarePaginator $entries
 */
interface ComputesProperties
{
    /**
     * Computed property to construct a query for paginator.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    public function getQueryProperty();

    /**
     * Computed property to execute the paginator.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getEntriesProperty();
}

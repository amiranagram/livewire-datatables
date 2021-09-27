<?php

namespace Amirami\LivewireDataTables\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\WithPagination as WithLivewirePagination;

trait WithPagination
{
    use WithLivewirePagination;

    protected $queryStringWithPagination = [
        'perPage',
    ];

    /**
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        return property_exists($this, 'perPage')
            ? $this->perPage
            : null;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @return LengthAwarePaginator
     */
    public function applyPagination($query): LengthAwarePaginator
    {
        return $query->paginate($this->getPerPage());
    }
}

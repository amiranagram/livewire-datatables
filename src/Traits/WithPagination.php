<?php

namespace Amirami\LivewireDataTables\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Livewire\WithPagination as WithLivewirePagination;

trait WithPagination
{
    use WithLivewirePagination;

    /**
     * @var int
     */
    public $perPage = 10;

    /**
     * @param Builder|QueryBuilder $query
     * @return LengthAwarePaginator
     */
    public function applyPagination($query): LengthAwarePaginator
    {
        return $query->paginate($this->perPage);
    }
}

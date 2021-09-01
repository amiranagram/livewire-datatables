<?php

namespace Amirami\LivewireDataTables\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Livewire\WithPagination as WithLivewirePagination;

trait WithPagination
{
    use WithLivewirePagination {
        WithLivewirePagination::getQueryString as getLivewireQueryString;
    }

    /**
     * @var int
     */
    public $perPage = 10;

    /**
     * @var array
     */
    public $queryStringWithPagination = [
        'page' => ['except' => 1]
    ];

    /**
     * @param Builder|QueryBuilder $query
     * @return LengthAwarePaginator
     */
    public function applyPagination($query): LengthAwarePaginator
    {
        return $query->paginate($this->perPage);
    }

    /**
     * Override Livewire's default pagination query string, so it gets called from parent.
     *
     * @inheritDoc
     */
    public function getQueryString()
    {
        return parent::getQueryString();
    }
}

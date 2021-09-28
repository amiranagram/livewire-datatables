<?php

namespace Amirami\LivewireDataTables\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\WithPagination as WithLivewirePagination;

trait WithPagination
{
    use WithLivewirePagination {
        queryStringWithPagination as baseQueryStringWithPagination;
        initializeWithPagination as baseInitializeWithPagination;
    }

    /**
     * @return array
     */
    public function queryStringWithPagination(): array
    {
        if ($this->getPerPage()) {
            return array_merge($this->baseQueryStringWithPagination(), [
                'perPage' => ['except' => $this->getPerPage()],
            ]);
        }

        return $this->baseQueryStringWithPagination();
    }

    /**
     * @return void
     */
    public function initializeWithPagination(): void
    {
        $this->baseInitializeWithPagination();

        if ($this->getPerPage()) {
            $this->perPage = request()->query('perPage', $this->perPage);
        }
    }

    /**
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        return $this->perPage ?? null;
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

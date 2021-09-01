<?php

namespace Amirami\LivewireDataTables\Traits;

trait WithSearch
{
    /**
     * @var string
     */
    public $search = '';

    /**
     * @var array
     */
    public $queryStringWithSearch = [
        'search' => ['except' => ''],
    ];

    /**
     * @return void
     */
    public function initializeWithSearch(): void
    {
        $this->search = request()->query('search', $this->search);
    }

    /**
     * @return void
     */
    public function updatedSearch(): void
    {
        if (property_exists($this, 'page')) {
            $this->resetPage();
        }
    }

    /**
     * @return array|string[]
     */
    public function getSearchableColumns(): array
    {
        return $this->searchableColumns ?? [];
    }

    /**
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function applySearching($query)
    {
        if (! $this->search) {
            return $query;
        }

        $searchableColumns = $this->getSearchableColumns() ?? [];

        return $query->when(count($searchableColumns), function ($query) use ($searchableColumns) {
            return $query->where(function ($query) use ($searchableColumns) {
                foreach ($searchableColumns as $key => $column) {
                    if ($key === 0) {
                        $query->where($column, 'LIKE', "%$this->search%");
                    } else {
                        $query->orWhere($column, 'LIKE', "%$this->search%");
                    }
                }
            });
        });
    }
}

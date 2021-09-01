<?php

namespace Amirami\LivewireDataTables\Traits;

trait ExecutesQuery
{
    /**
     * @var array|null
     */
    protected $dataTableTraits;

    /**
     * @return void
     */
    public function mountExecutesQuery(): void
    {
        $this->dataTableTraits = class_uses_recursive(static::class);
    }

    /**
     * @return void
     */
    public function hydrateExecutesQuery(): void
    {
        if (!$this->dataTableTraits) {
            $this->dataTableTraits = class_uses_recursive(static::class);
        }
    }

    /**
     * @inheritDoc
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getEntriesProperty()
    {
        if (in_array(WithSearch::class, $this->dataTableTraits, true)) {
            $this->applySearching($this->query);
        }

        if (in_array(WithSorting::class, $this->dataTableTraits, true)) {
            $this->applySorting($this->query);
        }

        if (in_array(WithCachedRows::class, $this->dataTableTraits, true)) {
            return $this->applyCaching(function () {
                $this->getEntries();
            });
        }

        return $this->getEntries();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    protected function getEntries()
    {
        if (in_array(WithPagination::class, $this->dataTableTraits, true)) {
            return $this->applyPagination($this->query);
        }

        return $this->query->get();
    }
}

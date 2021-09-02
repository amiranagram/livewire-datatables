<?php

namespace Amirami\LivewireDataTables\Traits;

/**
 * @property-read int $filtersApplied
 */
trait WithFiltering
{
    /**
     * @return int
     */
    public function getFiltersAppliedProperty(): int
    {
        return collect($this->getFilters())
            ->filter(function ($value, $key) {
                return $this->isFilterDirty($key);
            })
            ->count();
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters ?? [];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getFilter(string $key)
    {
        return value($this->filters[$key], $key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setFilter(string $key, $value): void
    {
        $this->filters[$key] = value($value, $key);
    }

    /**
     * @return void
     */
    public function resetFilters(): void
    {
        $this->reset('filters');
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isFilterDirty(string $key): bool
    {
        $freshInstance = new static($this->id);

        return $this->filters[$key] !== $freshInstance->filters[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isFilterNotDirty(string $key): bool
    {
        return ! $this->isFilterDirty($key);
    }
}

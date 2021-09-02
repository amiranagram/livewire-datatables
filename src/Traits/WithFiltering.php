<?php

namespace Amirami\LivewireDataTables\Traits;

use Livewire\Exceptions\PropertyNotFoundException;

/**
 * @property-read int $filtersApplied
 * @property array $filters
 */
trait WithFiltering
{
    /**
     * @return void
     * @throws PropertyNotFoundException
     */
    public function mountWithFiltering(): void
    {
        if (! property_exists($this, 'filters')) {
            throw new PropertyNotFoundException('filters', static::getName());
        }

        if (method_exists($this, 'getFilters')) {
            $this->filters = $this->getFilters();
        }

        if (is_null($this->filters)) {
            $this->filters = [];
        }
    }

    /**
     * @return int
     */
    public function getFiltersAppliedProperty(): int
    {
        return collect($this->filters)
            ->filter(function ($value, $key) {
                return $this->isFilterDirty($key);
            })
            ->count();
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

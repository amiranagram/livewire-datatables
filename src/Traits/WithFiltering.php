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
     * @return array[]
     */
    public function queryStringWithFiltering(): array
    {
        return [
            'filters' => ['except' => $this->getFilterInitialValues()],
        ];
    }

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
        return $this->filters[$key] !== $this->getFilterInitialValues($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isFilterNotDirty(string $key): bool
    {
        return ! $this->isFilterDirty($key);
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    protected function getFilterInitialValues(string $key = null)
    {
        $clone = new static($this->id);

        return is_null($key) ? $clone->filters : $clone->filters[$key];
    }
}

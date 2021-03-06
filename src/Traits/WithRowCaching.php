<?php

namespace Amirami\LivewireDataTables\Traits;

trait WithRowCaching
{
    /**
     * @var bool
     */
    protected $useCachedEntries = false;

    /**
     * @return bool
     */
    public function getRowCaching(): bool
    {
        return property_exists($this, 'rowCaching')
            ? $this->rowCaching
            : config('livewire-datatables.row_caching');
    }

    /**
     * @return void
     */
    public function useCachedEntries(): void
    {
        $this->useCachedEntries = true;
    }

    /**
     * @param callable $callback
     * @return \Illuminate\Contracts\Cache\Repository|\Illuminate\Support\HigherOrderTapProxy|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Exception
     */
    public function applyRowCaching(callable $callback)
    {
        if (! $this->getRowCaching()) {
            return $callback();
        }

        if ($this->useCachedEntries && cache()->has($cacheKey = $this->getCacheKey())) {
            return cache()->get($cacheKey);
        }

        return tap($callback(), function ($entries) {
            cache()->put($this->getCacheKey(), $entries);
        });
    }

    /**
     * @return string
     */
    public function getCacheKey(): string
    {
        return config('livewire-datatables.cache_key_prefix', 'data-table'). '.' . $this->id;
    }
}

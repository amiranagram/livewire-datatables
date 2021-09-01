<?php

namespace Amirami\LivewireDataTables\Traits;

trait WithCachedRows
{
    /**
     * @var bool
     */
    public $cachedEntries = false;

    /**
     * @var bool
     */
    protected $useCachedEntries = false;

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
    public function applyCaching(callable $callback)
    {
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
    protected function getCacheKey(): string
    {
        return 'data-table.' . $this->id;
    }
}

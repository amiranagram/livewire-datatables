<?php

namespace Amirami\LivewireDataTables\Traits;

use Illuminate\Support\Str;

trait InteractsWithDataTableTraits
{
    /**
     * @var string
     */
    protected $traitPrefix = 'Amirami\\LivewireDataTables\\Traits\\With';

    /**
     * @var array|null
     */
    protected $dataTableTraits;

    /**
     * @return void
     */
    public function mountInteractsWithDataTableTraits(): void
    {
        $this->dataTableTraits = class_uses_recursive(static::class);
    }

    /**
     * @return void
     */
    public function hydrateInteractsWithDataTableTraits(): void
    {
        if (! $this->dataTableTraits) {
            $this->dataTableTraits = class_uses_recursive(static::class);
        }
    }

    /**
     * @param string $feature
     * @return bool
     */
    protected function isFeatureEnabled(string $feature): bool
    {
        return in_array($this->traitPrefix . Str::studly($feature), $this->dataTableTraits, true);
    }

    /**
     * @param string $trait
     * @return bool
     */
    protected function isFirstPartyTrait(string $trait): bool
    {
        return Str::startsWith($trait, $this->traitPrefix);
    }
}

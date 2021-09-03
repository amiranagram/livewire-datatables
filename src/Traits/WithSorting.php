<?php

namespace Amirami\LivewireDataTables\Traits;

use Illuminate\Support\Collection;
use Livewire\Exceptions\PropertyNotFoundException;

/**
 * @property array $sorts
 */
trait WithSorting
{
    /**
     * @return void
     * @throws PropertyNotFoundException
     */
    public function mountWithSorting(): void
    {
        if (! property_exists($this, 'sorts')) {
            throw new PropertyNotFoundException('sorts', static::getName());
        }

        if (method_exists($this, 'getSorts')) {
            $this->sorts = $this->getSorts();
        }

        if (is_null($this->sorts)) {
            $this->sorts = [];
        }
    }

    /**
     * @return bool
     */
    public function getMultiColumnSorting(): bool
    {
        return property_exists($this, 'multiColumnSorting')
            ? $this->multiColumnSorting
            : config('livewire-datatables.multi_column_sorting');
    }

    /**
     * @param string $field
     * @param string|null $dir
     * @return void
     */
    public function sortBy(string $field, ?string $dir = null): void
    {
        $currentFieldDir = $this->sorts[$field] ?? null;

        $this->sorts = collect($this->sorts)
            ->filter(function () {
                return $this->getMultiColumnSorting();
            })
            ->when($dir, function (Collection $sorts, $dir) use ($field) {
                return $sorts->put($field, $dir);
            })
            ->when(! $dir && ! $currentFieldDir, function (Collection $sorts) use ($field) {
                return $sorts->put($field, 'asc');
            })
            ->when(! $dir && $currentFieldDir === 'asc', function (Collection $sorts) use ($field) {
                return $sorts->put($field, 'desc');
            })
            ->when(! $dir && $currentFieldDir === 'desc', function (Collection $sorts) use ($field) {
                return $sorts->forget($field);
            })
            ->toArray();

        if ($this->isFeatureEnabled(self::FEATURE_PAGINATION)) {
            $this->resetPage();
        }
    }

    /**
     * @param string $column
     * @return string|null
     */
    public function sortDir(string $column): ?string
    {
        return $this->sorts[$column] ?? null;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function applySorting($query)
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}

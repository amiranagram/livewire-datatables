<?php

namespace Amirami\LivewireDataTables\Traits;

trait WithSorting
{
    /**
     * @var array
     */
    public $sorts = [
        //
    ];

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
     * @param $field
     * @return void
     */
    public function sortBy($field): void
    {
        if (! isset($this->sorts[$field])) {
            if (! $this->getMultiColumnSorting()) {
                $this->reset('sorts');
            }

            $this->sorts[$field] = 'asc';
            $this->resetPageIfPossible();

            return;
        }

        if ($this->sorts[$field] === 'asc') {
            if (! $this->getMultiColumnSorting()) {
                $this->reset('sorts');
            }

            $this->sorts[$field] = 'desc';
            $this->resetPageIfPossible();

            return;
        }

        if ($this->sorts[$field] === 'desc' && ! $this->getMultiColumnSorting()) {
            $this->reset('sorts');

            $this->sorts[$field] = 'asc';
            $this->resetPageIfPossible();

            return;
        }

        if ($this->getMultiColumnSorting()) {
            $this->resetPageIfPossible();
            unset($this->sorts[$field]);

            return;
        }

        $this->resetPageIfPossible();
        $this->reset('sorts');
    }

    /**
     * @param string $column
     * @return string|null
     */
    public function sortDir(string $column): ?string
    {
        return $this->sorts[$column] ?? null;
    }

    private function resetPageIfPossible(): void
    {
        if ($this->isFeatureEnabled('pagination')) {
            $this->resetPage();
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function applySorting($query)
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}

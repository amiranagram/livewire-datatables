<?php

namespace Amirami\LivewireDataTables\Traits;

trait WithSorting
{
    /**
     * @var bool
     */
    public $multiColumnSorting = false;

    /**
     * @var array
     */
    public $sorts = [
        //
    ];

    /**
     * @param $field
     * @return void
     */
    public function sortBy($field): void
    {
        if (! isset($this->sorts[$field])) {
            if (! $this->multiColumnSorting) {
                $this->reset('sorts');
            }

            $this->sorts[$field] = 'asc';
            $this->resetPageIfPossible();

            return;
        }

        if ($this->sorts[$field] === 'asc') {
            if (! $this->multiColumnSorting) {
                $this->reset('sorts');
            }

            $this->sorts[$field] = 'desc';
            $this->resetPageIfPossible();

            return;
        }

        if ($this->sorts[$field] === 'desc' && ! $this->multiColumnSorting) {
            $this->reset('sorts');

            $this->sorts[$field] = 'asc';
            $this->resetPageIfPossible();

            return;
        }

        if ($this->multiColumnSorting) {
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
        if ($this->hasLivewireDataTablesTrait('pagination')) {
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

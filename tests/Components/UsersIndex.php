<?php

namespace Amirami\LivewireDataTables\Tests\Components;

use Amirami\LivewireDataTables\DataTable;
use Amirami\LivewireDataTables\Tests\Models\User;
use Amirami\LivewireDataTables\Traits\WithFiltering;
use Amirami\LivewireDataTables\Traits\WithSearching;
use Amirami\LivewireDataTables\Traits\WithSorting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UsersIndex extends DataTable
{
    use WithSorting;
    use WithSearching;
    use WithFiltering;

    /**
     * @var @array
     */
    public $sorts;

    /**
     * @var string[]
     */
    public $searchableColumns = [
        'name',
        'email',
    ];

    /**
     * @var string[]
     */
    public $filters = [
        'registered-at-min' => '',
        'registered-at-max' => '',
    ];

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->sorts['name'] = 'desc';
    }

    /**
     * @inheritDoc
     */
    public function getQueryProperty(): Builder
    {
        return User::query()
            ->when($this->isFilterDirty('registered-at-min'), function (Builder $query) {
                $query->whereDate('created_at', '>=', Carbon::parse($this->getFilter('registered-at-min')));
            })
            ->when($this->isFilterDirty('registered-at-max'), function (Builder $query) {
                $query->whereDate('created_at', '<=', Carbon::parse($this->getFilter('registered-at-max')));
            });
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        $users = $this->entries;

        return view('livewire.users-index', compact('users'));
    }
}

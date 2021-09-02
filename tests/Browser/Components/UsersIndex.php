<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Components;

use Amirami\LivewireDataTables\DataTable;
use Amirami\LivewireDataTables\Tests\Browser\Models\User;
use Amirami\LivewireDataTables\Traits\WithSearching;
use Amirami\LivewireDataTables\Traits\WithSorting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class UsersIndex extends DataTable
{
    use WithSorting;
    use WithSearching;

    /**
     * @var string[]
     */
    public $searchableColumns = [
        'name',
        'email',
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
        return User::query();
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

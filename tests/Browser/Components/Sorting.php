<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Components;

use Amirami\LivewireDataTables\DataTable;
use Amirami\LivewireDataTables\Tests\Browser\Models\Comment;
use Amirami\LivewireDataTables\Traits\WithSorting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class Sorting extends DataTable
{
    use WithSorting;

    /**
     * @inheritDoc
     */
    public function getQueryProperty(): Builder
    {
        return Comment::query()->take(3);
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        $comments = $this->entries;

        return view('livewire.sorting', compact('comments'));
    }
}

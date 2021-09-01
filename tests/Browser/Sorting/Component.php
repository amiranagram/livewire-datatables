<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Sorting;

use Amirami\LivewireDataTables\DataTable;
use Amirami\LivewireDataTables\Traits\WithSorting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\View as ViewFacade;

class Component extends DataTable
{
    use WithSorting;

    /**
     * @inheritDoc
     */
    public function getQueryProperty(): Builder
    {
        return Comment::query();
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        $comments = $this->entries;

        return ViewFacade::file(__DIR__.'/view.blade.php', compact('comments'));
    }
}

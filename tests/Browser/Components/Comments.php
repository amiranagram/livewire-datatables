<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Components;

use Amirami\LivewireDataTables\DataTable;
use Amirami\LivewireDataTables\Tests\Browser\Models\Comment;
use Amirami\LivewireDataTables\Traits\WithSorting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class Comments extends DataTable
{
    use WithSorting;

    /**
     * @var @array
     */
    public $sorts;

    /**
     * @var bool
     */
    public $multiColumnSorting = true;

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

        return view('livewire.comments', compact('comments'));
    }
}

<?php

namespace Amirami\LivewireDataTables\Tests\Components;

use Amirami\LivewireDataTables\DataTable;
use Amirami\LivewireDataTables\Tests\Models\Post;
use Amirami\LivewireDataTables\Traits\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class BlogPosts extends DataTable
{
    use WithPagination;

    /**
     * @inheritDoc
     */
    public function getQueryProperty(): Builder
    {
        return Post::query();
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        $posts = $this->entries;

        return view('livewire.blog-posts', compact('posts'));
    }
}

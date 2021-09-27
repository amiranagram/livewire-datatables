<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\Tests\Components\BlogPosts;
use Laravel\Dusk\Browser;
use Livewire\Livewire;

class PaginationTest extends TestCase
{
    /** @test */
    public function it_displays_number_of_entries_defined_in_per_page(): void
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, BlogPosts::class)

            ;
        });
    }
}

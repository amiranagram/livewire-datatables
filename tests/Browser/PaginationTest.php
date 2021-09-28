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
                ->assertSee('sunt aut facere repellat provident occaecati excepturi optio reprehenderit')
                ->assertSee('rem alias distinctio quo quis')
                ->assertDontSee('repellendus qui recusandae incidunt voluptates tenetur qui omnis exercitationem')
                ->assertQueryStringMissing('perPage')
                // Select 10 users per page.
                ->waitForLivewire()->select('@perPage', '10')
                ->assertSelected('@perPage', '10')
                ->assertSee('sunt aut facere repellat provident occaecati excepturi optio reprehenderit')
                ->assertDontSee('rem alias distinctio quo quis')
                ->assertDontSee('repellendus qui recusandae incidunt voluptates tenetur qui omnis exercitationem')
                ->assertQueryStringHas('perPage', 10)
                // Select 50 users per page.
                ->waitForLivewire()->select('@perPage', '50')
                ->assertSelected('@perPage', '50')
                ->assertSee('sunt aut facere repellat provident occaecati excepturi optio reprehenderit')
                ->assertSee('rem alias distinctio quo quis')
                ->assertSee('repellendus qui recusandae incidunt voluptates tenetur qui omnis exercitationem')
                ->assertQueryStringHas('perPage', 50)
            ;
        });
    }
}

<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\Tests\Browser\Components\UsersIndex;
use Laravel\Dusk\Browser;
use Livewire\Livewire;

class SearchingTest extends TestCase
{
    /** @test */
    public function it_searches_for_users(): void
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, UsersIndex::class)
                ->assertSee('Amir')
                ->assertSee('Bardh')
                ->assertSee('George')

                ->waitForLivewire()->type('@input', 'Amir')

                ->assertSee('Amir')
                ->assertDontSee('Bardh')
                ->assertDontSee('George')

                ->waitForLivewire()->type('@input', 'Bardh')

                ->assertSee('Bardh')
                ->assertDontSee('Amir')
                ->assertDontSee('George')

                ->waitForLivewire()->type('@input', 'a')

                ->assertSee('Amir')
                ->assertSee('Bardh')
                ->assertDontSee('George')
            ;
        });
    }

    /** @test */
    public function it_fails_to_search_user_by_email_when_column_email_is_not_searchable(): void
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, UsersIndex::class)
                ->assertSee('Amir')
                ->assertSee('Bardh')
                ->assertSee('George')

                ->waitForLivewire()->type('@input', 'me@amirrami.com')

                ->assertSee('Amir')
                ->assertDontSee('Bardh')
                ->assertDontSee('George')

                ->waitForLivewire()->click('@unsetEmailAsSearchable')

                ->assertDontSee('Amir')
                ->assertDontSee('Bardh')
                ->assertDontSee('George')
            ;
        });
    }
}

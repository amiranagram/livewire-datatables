<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\Tests\Components\UsersIndex;
use Laravel\Dusk\Browser;
use Livewire\Livewire;

class FilteringTest extends TestCase
{
    /** @test */
    public function it_filters_users_between_registered_at_min_and_max_dates(): void
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, UsersIndex::class)
                ->assertSee('Amir')
                ->assertSee('Bardh')
                ->assertSee('George')
                ->assertQueryStringMissing('filters')
                // Filter user created from 2021-08-02.
                ->waitForLivewire()->type('@registeredAtMinDate', '2021-08-02')
                ->assertDontSee('Amir')
                ->assertSee('Bardh')
                ->assertSee('George')
                ->assertQueryStringHas('filters', [
                    'registered-at-min' => '2021-08-02',
                    'registered-at-max' => '',
                ])
                // Filter user created from 2021-08-02 to 2021-09-02.
                ->waitForLivewire()->type('@registeredAtMaxDate', '2021-09-02')
                ->assertDontSee('Amir')
                ->assertSee('Bardh')
                ->assertDontSee('George')
                ->assertQueryStringHas('filters', [
                    'registered-at-min' => '2021-08-02',
                    'registered-at-max' => '2021-09-02',
                ])
                // Clear `registered-min-date`. Filters users created to 2021-09-02.
                ->waitForLivewire()->click('@clearRegisteredAtMinDate')
                ->assertSee('Amir')
                ->assertSee('Bardh')
                ->assertDontSee('George')
                ->assertQueryStringHas('filters', [
                    'registered-at-min' => '',
                    'registered-at-max' => '2021-09-02',
                ])
                // Clear `registered-max-date`. There are no filters left. Shows all users.
                ->waitForLivewire()->click('@clearRegisteredAtMaxDate')
                ->assertSee('Amir')
                ->assertSee('Bardh')
                ->assertSee('George')
                ->assertQueryStringMissing('filters')
            ;
        });
    }
}

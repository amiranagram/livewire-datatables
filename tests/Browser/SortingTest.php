<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\Tests\Browser\Components\Sorting;
use Livewire\Livewire;

class SortingTest extends TestCase
{
    /** @test */
    public function it_sorts_data_by_message_column(): void
    {
        $this->browse(function ($browser) {
            Livewire::visit($browser, Sorting::class)
                ->assertSee('Hello 2')
                ->assertDontSee('Hello 1')

                ->waitForLivewire()->click('@sortByMessage')

                ->assertSee('Hello 1')
                ->assertDontSee('Hello 9')

                ->waitForLivewire()->click('@sortByMessage')

                ->assertSee('Hello 9')
                ->assertDontSee('Hello 10')
            ;
        });
    }
}

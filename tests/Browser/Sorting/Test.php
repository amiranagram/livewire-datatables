<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Sorting;

use Amirami\LivewireDataTables\Tests\Browser\TestCase;
use Livewire\Livewire;

class Test extends TestCase
{
    /** @test */
    public function it_sorts_data_by_message_column(): void
    {
        $this->browse(function ($browser) {
            Livewire::visit($browser, Component::class)
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

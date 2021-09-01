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
            ;
        });
    }
}

<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\Tests\Components\Comments;
use Laravel\Dusk\Browser;
use Livewire\Livewire;

class SortingTest extends TestCase
{
    /** @test */
    public function it_sorts_comments_by_message_column(): void
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, Comments::class)
                // Without sort. Sort by ID by default.
                ->assertSee('Repellat aut vero quo.')
                ->assertSee('Veritatis eaque eos voluptatem dolorem sequi velit.')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertDontSee('Sunt hic aut soluta quo.')
                // Sort by message, ascending.
                ->waitForLivewire()->click('@sortByMessage')
                ->assertSee('Aut quam qui perferendis.')
                ->assertSee('Dolores sit hic ea expedita.')
                ->assertSee('Eius incidunt est quia quisquam voluptas perspiciatis.')
                ->assertDontSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                // Sort by message, descending.
                ->waitForLivewire()->click('@sortByMessage')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertSee('Veritatis eaque eos voluptatem dolorem sequi velit.')
                ->assertSee('Tenetur sit magni explicabo voluptatem exercitationem quos dolor dolor.')
                ->assertDontSee('Aut quam qui perferendis.')
            ;
        });
    }

    /** @test */
    public function it_sorts_comments_by_message_and_id_columns_using_multi_column_sorting(): void
    {
        config()->set('livewire-datatables.multi_column_sorting', true);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, Comments::class)
                // Without sort. Sort by ID by default.
                ->assertSee('Repellat aut vero quo.')
                ->assertSee('Veritatis eaque eos voluptatem dolorem sequi velit.')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertDontSee('Sunt hic aut soluta quo.')
                // Sort by likes, ascending.
                ->waitForLivewire()->click('@sortByLikes')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertSee('Eius incidunt est quia quisquam voluptas perspiciatis.')
                ->assertSee('Sunt hic aut soluta quo.')
                ->assertDontSee('Repellat aut vero quo.')
                // Sort by message, ascending.
                ->waitForLivewire()->click('@sortByMessage')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertSee('Eius incidunt est quia quisquam voluptas perspiciatis.')
                ->assertSee('Mollitia qui nam magnam mollitia similique incidunt.')
                ->assertDontSee('Repellat aut vero quo.')
                // Sort by message, descending.
                ->waitForLivewire()->click('@sortByMessage')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertSee('Eius incidunt est quia quisquam voluptas perspiciatis.')
                ->assertSee('Sunt hic aut soluta quo.')
                ->assertDontSee('Repellat aut vero quo.')
                // Sort by likes, descending.
                ->waitForLivewire()->click('@sortByLikes')
                ->assertSee('Tenetur sit magni explicabo voluptatem exercitationem quos dolor dolor.')
                ->assertSee('Dolores sit hic ea expedita.')
                ->assertSee('Veritatis eaque eos voluptatem dolorem sequi velit.')
                ->assertDontSee('Sunt hic aut soluta quo.')
                // Remove likes from sorts. Comments will be sorted by message, descending.
                ->waitForLivewire()->click('@sortByLikes')
                ->assertSee('Voluptas accusantium voluptatem laudantium sit voluptatem rem.')
                ->assertSee('Veritatis eaque eos voluptatem dolorem sequi velit.')
                ->assertSee('Tenetur sit magni explicabo voluptatem exercitationem quos dolor dolor.')
                ->assertDontSee('Sunt hic aut soluta quo.')
            ;
        });
    }
}

<?php

namespace Amirami\LivewireDataTables\Tests\Feature;

use Amirami\LivewireDataTables\Tests\Components\UsersIndex;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

class RowCachingTest extends TestCase
{
    /** @test */
    public function it_stores_entries_in_cache(): void
    {
        $testable = Livewire::test(UsersIndex::class)
            ->call('editUser', 1);

        $cacheKey = (new UsersIndex($testable->id()))->getCacheKey();

        $this->assertTrue(Cache::has($cacheKey));
    }
}

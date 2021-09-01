<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Sorting;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Comment extends Model
{
    use Sushi;

    /**
     * @var array
     */
    protected $rows = [
        ['message' => 'Hello 2'],
        ['message' => 'Hello 9'],
        ['message' => 'Hello 3'],
        ['message' => 'Hello 4'],
        ['message' => 'Hello 10'],
        ['message' => 'Hello 6'],
        ['message' => 'Hello 7'],
        ['message' => 'Hello 5'],
        ['message' => 'Hello 1'],
        ['message' => 'Hello 8'],
    ];
}

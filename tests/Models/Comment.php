<?php

namespace Amirami\LivewireDataTables\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Comment extends Model
{
    use Sushi;

    /**
     * @var array
     */
    protected $rows = [
        [
            'message' => 'Repellat aut vero quo.',
            'likes' => 10,
        ],
        [
            'message' => 'Veritatis eaque eos voluptatem dolorem sequi velit.',
            'likes' => 32,
        ],
        [
            'message' => 'Voluptas accusantium voluptatem laudantium sit voluptatem rem.',
            'likes' => 1,
        ],
        [
            'message' => 'Sunt hic aut soluta quo.',
            'likes' => 5,
        ],
        [
            'message' => 'Dolores sit hic ea expedita.',
            'likes' => 64,
        ],
        [
            'message' => 'Est iure quia sunt eos fuga.',
            'likes' => 12,
        ],
        [
            'message' => 'Mollitia qui nam magnam mollitia similique incidunt.',
            'likes' => 5,
        ],
        [
            'message' => 'Aut quam qui perferendis.',
            'likes' => 7,
        ],
        [
            'message' => 'Tenetur sit magni explicabo voluptatem exercitationem quos dolor dolor.',
            'likes' => 312,
        ],
        [
            'message' => 'Eius incidunt est quia quisquam voluptas perspiciatis.',
            'likes' => 2,
        ],
    ];
}

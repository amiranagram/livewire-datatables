<?php

namespace Amirami\LivewireDataTables\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Sushi\Sushi;

class User extends Authenticatable
{
    use Sushi;

    /**
     * @var string[]
     */
    protected $schema = [
        'created_at' => 'dateTime'
    ];

    /**
     * @var string[][]
     */
    protected $rows = [
        [
            'name' => 'Amir',
            'email' => 'me@amirrami.com',
            'password' => '',
            'created_at' => '2021-08-01 00:00'
        ],
        [
            'name' => 'Bardh',
            'email' => 'bardh@example.com',
            'password' => '',
            'created_at' => '2021-09-01 00:00'
        ],
        [
            'name' => 'George Orwell',
            'email' => 'george@example.com',
            'password' => '',
            'created_at' => '2021-09-03 00:00'
        ],
    ];
}

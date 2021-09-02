<?php

namespace Amirami\LivewireDataTables\Tests\Browser\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Sushi\Sushi;

class User extends Authenticatable
{
    use Sushi;

    protected $rows = [
        [
            'name' => 'Amir',
            'email' => 'me@amirrami.com',
            'password' => '',
        ],
        [
            'name' => 'Bardh',
            'email' => 'bardh@example.com',
            'password' => '',
        ],
        [
            'name' => 'George Orwell',
            'email' => 'george@example.com',
            'password' => '',
        ],
    ];
}

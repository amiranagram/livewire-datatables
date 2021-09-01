<?php

namespace Amirami\LivewireDataTables;

use Amirami\LivewireDataTables\Contracts\ComputesProperties;
use Amirami\LivewireDataTables\Traits\ExecutesQuery;
use Livewire\Component;

abstract class DataTable extends Component implements ComputesProperties
{
    use ExecutesQuery;
}

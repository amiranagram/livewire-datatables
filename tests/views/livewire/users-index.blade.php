<div>
    <input type="text" wire:model="user.name" dusk="userName">

    <input type="text" wire:model="user.email" dusk="userEmail">

    @foreach($users as $user)
        <p wire:key="comment-{{ $user->id }}">{{ $user->name }}</p>
    @endforeach

    <input type="text" wire:model="search" dusk="input">

    <input type="text" wire:model="filters.registered-at-min" dusk="registeredAtMinDate">

    <input type="text" wire:model="filters.registered-at-max" dusk="registeredAtMaxDate">

    <br><br>
    <button type="button" wire:click="$set('searchableColumns', ['name'])" dusk="unsetEmailAsSearchable">
        Set Email as Searchable
    </button>

    <br><br>
    <button type="button" wire:click="$set('filters.registered-at-min', '')" dusk="clearRegisteredAtMinDate">
        Clear Min Date
    </button>

    <br><br>
    <button type="button" wire:click="$set('filters.registered-at-max', '')" dusk="clearRegisteredAtMaxDate">
        Clear Max Date
    </button>
</div>

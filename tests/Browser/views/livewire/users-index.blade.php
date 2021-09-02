<div>
    @foreach($users as $user)
        <p wire:key="comment-{{ $user->id }}">{{ $user->name }}</p>
    @endforeach

    <input type="text" wire:model="search" dusk="input">

    <button type="button" wire:click="$set('searchableColumns', ['name'])" dusk="unsetEmailAsSearchable">
        Set Email as Searchable
    </button>
</div>

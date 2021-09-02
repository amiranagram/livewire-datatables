<div>
    @foreach($comments as $comment)
        <p wire:key="comment-{{ $comment->id }}">{{ $comment->message }}</p>
    @endforeach

    <button wire:click="sortBy('message')" wire:loading.attr="disabled" dusk="sortByMessage">Sort by name</button>
</div>

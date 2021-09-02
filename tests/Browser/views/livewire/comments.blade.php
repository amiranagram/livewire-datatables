<div>
    @foreach($comments as $comment)
        <p wire:key="comment-{{ $comment->id }}">{{ $comment->message }}</p>
    @endforeach

    <button
        wire:click="sortBy('message')"
        wire:loading.attr="disabled"
        wire:target="sortBy('message')"
        dusk="sortByMessage"
    >
        Sort by name
    </button>

    <button
        wire:click="sortBy('likes')"
        wire:loading.attr="disabled"
        wire:target="sortBy('likes')"
        dusk="sortByLikes"
    >
        Sort by likes
    </button>
</div>

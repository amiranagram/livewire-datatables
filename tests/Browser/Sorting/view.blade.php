<div>
    @foreach($comments as $comment)
        <p wire:key="comment-{{ $comment->id }}">{{ $comment->message }}</p>
    @endforeach
</div>

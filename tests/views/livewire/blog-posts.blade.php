<div>
    <h1>Blog</h1>

    <select wire:model="perPage" dusk="perPage">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>

    @foreach($posts as $post)
        <div wire:key="post-{{ $post->id }}">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->body }}</p>
        </div>
    @endforeach

    {{ $posts->links() }}
</div>

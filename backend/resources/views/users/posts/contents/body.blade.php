<a href="{{ route('post.show', $post->id) }}">
    <img src="{{ App\Models\Post::showImage($post->image) }}" class="card-img rounded-0" />
</a>
<!-- [end] post image !-->

<div class="d-flex flex-row bd-highlight mb-3">
    <div class="mt-1 ms-3 bd-highlight">
        @if (\App\Models\Like::isLiked(Auth::user()->id, $post->id)) 
            <form method="post" action="{{ route('like.destroy', $post->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm"><i class="fas fa-heart fa-2x"></i></button>
            </form>
        @else
            <form method="post" action="{{ route('like.store', $post->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm"><i class="far fa-heart fa-2x"></i></button>
            </form>
        @endif
    </div>
    <div class="mt-2 bd-highlight">{{ $post->likes->count() }}</div>
    <div class="mt-2 ms-2 bd-highlight">
        @foreach($post->categoryPost as $categoryPost)
            @if ($categoryPost->category)
            <div class="badge bg-secondary text-wrap">
                {{ $categoryPost->category->name }}
            </div>
            @endif
        @endforeach
    </div>
</div>
<!-- [end] post likes / categories !-->

<div class="mb-4 ms-4">
    <div class="row mb-2">
        <div class="col-12">
            <strong>{{ $post->user->name }}</strong> <span class="fw-light">{{ $post->description }}</span>
        </div>
    </div>
</div>
<!-- [end] post user name and post description !-->
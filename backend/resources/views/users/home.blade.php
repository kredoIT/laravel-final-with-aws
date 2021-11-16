@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row justify-content-center ms-5">
    <div class="col-2 order-md-last">
        @include('users.posts.contents.suggestions', ['suggestedUsers', $suggestedUsers])
    </div>
    <!-- [end] suggestion list !-->

    <div class="col-9">
        @if ($posts->isNotEmpty())
            @foreach($posts as $post)
                @if ($post->user)
                <div class="card mb-4">
                    @include('users.posts.contents.title', ['post' => $post])
                    <!-- [end] post title !-->

                    @include('users.posts.contents.body', ['post' => $post])
                    <!-- [end] post body !-->

                    @include('users.posts.contents.comments', ['post' => $post])
                    <!-- [end] comment list !-->

                </div> <!-- [end] POST !-->
                @endif
            @endforeach
        @endif
    </div>
</div>

@endsection

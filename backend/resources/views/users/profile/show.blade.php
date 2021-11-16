@extends('layouts.app')

@section('title', 'Show')

@section('content')

<div class="row">
	<div class="col-3">
		@if ($user->avatar)
        <img src="{{ App\Models\User::showAvatar($user->avatar) }}" class="img-thumbnail mb-3" /> 
        @else
        <i class="far fa-user-circle fa-10x mt-3 ms-5"></i>
        @endif
	</div>
	<div class="col-6 pt-3">
		<div class="row">
			<div class="col-12 mt-2">
				<form 
					method="post" 
					action="{{ !\App\Models\Follow::isFollowed(Auth::user()->id, $user->id) ? route('follow.store', $user->id) : route('follow.destroy', $user->id) }}"
				>
					<span class="fw-bold fs-5">{{ $user->name }}</span>
					
					@if (Auth::user()->id === $user->id)
						<a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary btn-sm btn-block mb-1 ms-3">Edit Profile</a>
					@else
						@if (!\App\Models\Follow::isFollowed(Auth::user()->id, $user->id))
							@csrf
							<button type="submit" class="btn btn-outline-secondary btn-sm btn-block mb-1 ms-3">Follow</button>
						@else
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-secondary btn-sm mb-1 ms-3">Unfollow</button>
						@endif
					@endif
				</form>

				<p>
					<span class="pe-2">
						<strong>{{ $user->posts()->count() }}</strong> posts
					</span> 
					<span class="pe-2">
						<strong>{{ $user->followers()->count() }}</strong> followers
					</span> 
					<span>
						<strong>{{ $user->following()->count() }}</strong> followings
					</span>
				</p>
				<div class="d-flex justify-content-between align-items-center mt-1">
					<strong>{{ $user->introduction }}</strong>
				</div>
			</div>
		</div>		
	</div>
</div>

<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
	@if ($user->posts->isNotEmpty())
	
		@foreach($user->posts as $post)
		<a href="{{ route('post.show', $post->id) }}">
			<div class="col">
				<div class="card card-cover h-100 overflow-hidden shadow-md">
					<img src="{{ App\Models\Post::showImage($post->image) }}" class="rounded rounded-5 "/>
				</div>
			</div>
		</a>
		@endforeach

	@endif
</div>

@endsection
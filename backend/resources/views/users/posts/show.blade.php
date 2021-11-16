@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 ">
	<div class="col-6 pt-5 pb-5 border bg-dark rounded-start ">
		<img src="{{ App\Models\Post::showImage($post->image) }}" class="card-img mt-5 mb-5"/>
	</div>

	<div class="col-6 pt-3 ps-3 pe-3">
		<div class="row mb-2">
			<div class="col-md-1">
				@if ($post->user->avatar)
					<img 
		            	src="{{ App\Models\User::showAvatar($post->user->avatar) }}" 
		            	class="rounded border border-1 rounded-circle" 
						style="height: 2.4rem; width: 2.4rem; "
		            /> 
				@else
					<i class="far fa-user-circle text-muted" style="font-size: 2.4rem; "></i>
				@endif
			</div>
			<div class="col-md-10 mb-1">
				<strong>{{ $post->user->name }}</strong> &nbsp; <span class="fw-light">{{ $post->description }}</span>
			</div>
		</div>
		<div class="mb-5">
			@foreach($post->categoryPost as $categoryPost)
	        <div class="badge bg-secondary text-wrap" style="width: 6;">
	            {{ $categoryPost->category->name }}
	        </div>
	        @endforeach
		</div>

		<div class="mb-3">
	        @if ($comments->isNotEmpty())
		        @php $style = $comments->count() > 3 ? 'height: 20rem; overflow-x: hidden; overflow-y: scroll;' : '' @endphp

		        <div class="row mb-2" style="{{ $style }}">
		            <div class="panel panel-default widget">
		                <div class="panel-body">
		                    <ul class="list-group">
		                        @foreach($comments->sortByDesc('id') as $comment)
		                        <li class="list-group-item" style="padding: 0.5rem 0.3em;">
		                            <div class="row">
		                                <div class="col-md-1 ps-3">
		                                    @if ($comment->user->avatar)
		                                        <img 
		                                        	src="{{ App\Models\User::showAvatar($comment->user->avatar) }}" 
		                                        	class="rounded border border-1 rounded-circle" 
													style="height: 2.4rem; width: 2.4rem; "
		                                        /> 
		                                    @else
		                                        <i class="far fa-user-circle text-muted" style="font-size: 2.4rem; "></i>
		                                    @endif  
		                                </div>
		                                <div class="col-md-10 ps-3">
											<div class="mb-1">
												<strong>{{ $comment->user->name }}</strong> <span class="text-muted">{{ date("D, M d Y", strtotime($comment->created_at) ) }}</span>
											</div>

											<span class="text-dark">
												{{ $comment->body }}
											</span>
		                                </div>
		                            </div>
		                        </li>
		                        @endforeach
		                    </ul>
		                </div>
		            </div>
		        </div>
		    @endif
        </div>

		<div class="mb-3">
        	<form method="post" action="{{ route('comment.store', $post->id) }}">
        		@csrf
        		<textarea name="comment_body{{ $post->id }}" class="form-control mb-2" rows="1" placeholder="Write your comment here"></textarea>

        		@error('comment_body' . $post->id)
        			<p class="text-danger">{{ $message }}</p>
        		@enderror

				<button class="btn btn-primary btn-sm" type="submit">Submit</button>	
			</form>
        </div>
		
	</div>

</div>
@endsection

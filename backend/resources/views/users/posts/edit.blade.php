@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<form method="post" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
	@csrf
	@method('PATCH')
	<div class="mb-3">
		<label for="category" class="form-label d-block"><h6>Category</h6></label>
		@foreach($categories as $category)
			<div class="form-check form-check-inline">
				<input 
					class="form-check-input" 
					name="category[]" 
					type="checkbox" 
					id="{{ $category->name }}" 
					value="{{ $category->id }}" 
					{{ in_array($category->id, $categoryPosts) ? 'checked' : '' }}
				>
				<label class="form-check-label" for="{{ $category->name }}"><h6>{{ $category->name }}</h6></label>
			</div>
		@endforeach

		@error('category')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<div class="mb-3">
		<label for="description" class="form-label"><h6>Description</h6></label>
		<textarea name="description" class="form-control" id="description" rows="3" placeholder="What's on your mind">{{ old('description', $post->description)}}
		</textarea>

		@error('description')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<div class="mb-3">
		<input name="image" type="file" class="form-control" />

		@error('image')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection

@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
	@csrf
	<div class="mb-3">
		<label for="category" class="form-label d-block"><h6>Category <span class="text-muted">(up to 3 categories)</span></h6></label>

		@foreach($categories as $category)
			<div class="form-check form-check-inline">
				<input 
					class="form-check-input" 
					name="category[]" 
					type="checkbox" 
					id="{{ $category->name }}" 
					value="{{ $category->id }}" 
					{{ is_array(old('category')) && in_array($category->id, old('category')) ? 'checked' : '' }}
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
		<textarea name="description" class="form-control" id="description" rows="3" placeholder="What's on your mind">{{ old('description') }}</textarea>
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

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

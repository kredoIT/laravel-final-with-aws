<!-- Modal -->
<div class="modal fade" id="categoryEdit-{{ $category->id }}" tabindex="-1" aria-labelledby="categoryEditModal" aria-hidden="true">
	<form method="post" action="{{ route('admin.categories.update', $category->id) }}">
		@csrf
		@method('PATCH')
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-primary">
						<i class="fas fa-edit"></i> Edit Category
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="text" name="name{{ $category->id }}" class="form-control form-control-sm" placeholder="Category name" value="{{ old('name' . $category->id, $category->name) }}" />

					@error('name' . $category->id)
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-sm btn-primary">
						Submit
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
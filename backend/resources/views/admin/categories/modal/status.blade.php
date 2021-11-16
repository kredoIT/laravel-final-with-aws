<!-- Modal -->
<div class="modal fade" id="categoryStatus-{{ $category->id }}" tabindex="-1" aria-labelledby="categoryStatusModal" aria-hidden="true">
	<form method="post" action="{{ route('admin.categories.destroy', $category->id) }}">
		@csrf
		@method('DELETE')
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title text-danger">
					<i class="fas fa-exclamation-circle"></i> Delete confirmation
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Are you sure you want to delete this category?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-sm btn-danger">
						Delete
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
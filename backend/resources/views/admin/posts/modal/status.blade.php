<!-- Modal -->
<div class="modal fade" id="postStatus-{{ $post->id }}" tabindex="-1" aria-labelledby="postStatusModal" aria-hidden="true">
	<form method="post" action="{{ !$post->trashed() ? route('admin.posts.deactivate', $post->id) : route('admin.posts.activate', $post->id) }}">
		@csrf
		@method('PATCH')
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title {{ !$post->trashed() ? 'text-danger' : 'text-primary' }}">
					@if (!$post->trashed())
						<i class="fas fa-eye-slash"></i> Hide
					@else
						<i class="fas fa-eye"></i> Display
					@endif
					confirmation
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Are you sure you want to @if (!$post->trashed())
						hide
					@else
						display
					@endif 

					this post? 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-sm {{ !$post->trashed() ? 'btn-danger' : 'btn-primary' }}">
						@if (!$post->trashed())
							Hide
						@else
							Display
						@endif 
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
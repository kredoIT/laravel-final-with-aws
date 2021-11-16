<!-- Modal -->
<div class="modal fade" id="activateUser-{{ $user->id }}" tabindex="-1" aria-labelledby="activateUserModal" aria-hidden="true">
	<form method="post" action="{{ !$user->trashed() ? route('admin.users.deactivate', $user->id) : route('admin.users.activate', $user->id) }}">
		@csrf
		@method('PATCH')
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title {{ !$user->trashed() ? 'text-danger' : 'text-primary' }}">
					@if (!$user->trashed())
						<i class="fas fa-user-slash"></i> Deactivate
					@else
						<i class="fas fa-user-check"></i> Activate
					@endif
					confirmation
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Are you sure you want to @if (!$user->trashed())
						deactivate
					@else
						activate
					@endif 

					this user? 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-sm {{ !$user->trashed() ? 'btn-danger' : 'btn-primary' }}">
						@if (!$user->trashed())
							Deactivate
						@else
							Activate
						@endif 
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
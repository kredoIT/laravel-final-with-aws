<div class="card-title m-1">
    <div class="row">
        <div class="col-1 ps-4 pt-1">
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-black-50">
                @if ($post->user->avatar)
                    <img src="{{ App\Models\User::showAvatar($post->user->avatar) }}" class="border rounded-circle mb-2" style="height: 2.4rem; width: 2.4rem; " /> 
                @else
                    <i class="far fa-user-circle" style="font-size: 2.3rem;"></i>
                @endif
            </a>
        </div>
        <div class="col-4 pt-3" style="padding-left: .1rem;">
            <a 
                href="{{ route('profile.show', $post->user->id) }}" 
                class="text-body" 
                style="text-decoration: none !important;"
            ><h6>{{ $post->user->name }}</h6></a>
        </div>
        <div class="col-7 pe-4 pt-2 text-end">
            @if (Auth::user()->id === $post->user->id)
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdown">
                        <li><a class="dropdown-item text-primary" href="{{ route('post.edit', $post->id) }}"><i class="far fa-edit"></i> Edit</a></li>
                        <li>
                            <a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"  >
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                @if (!\App\Models\Follow::isFollowed(Auth::user()->id, $post->user->id))
                    <form method="post" action="{{ route('follow.store', $post->user->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Follow</button>
                    </form>
                @else
                    <form method="post" action="{{ route('follow.destroy', $post->user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary btn-sm">Unfollow</button>
                    </form>
                @endif
            @endif
        </div>
        <!-- [end] post actions !-->
    </div>  
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-circle"></i> Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this post?
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('post.delete', $post->id)}}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- [end] delete modal !-->
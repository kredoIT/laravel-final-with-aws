<div class="text-center fw-bold text-muted mb-2">Suggestions</div>
@if ($suggestedUsers->isNotEmpty())
    @foreach($suggestedUsers as $user)
    <div class="row mb-2">
        <div class="col-4 text-end">
            <a href="{{ route('profile.show', $user->id) }}" class="text-black-50">
                @if ($user->avatar)
                <img src="{{ App\Models\User::showAvatar($user->avatar) }}" class="border rounded-circle" style="height: 2.4rem; width: 2.4rem; " /> 
                @else
                <i class="far fa-user-circle" style="font-size: 2.4rem;"></i>
                @endif
            </a>
        </div>
        <div class="col-7 mt-2 ps-0">
            <a href="{{ route('profile.show', $user->id) }}" class="text-body" style="text-decoration: none !important;">
                <p class="fw-bold" style="font-size: 12px;">{{ $user->name }}</p>
            </a>
        </div>
        <div class="col-1 ps-0 text-start" style="margin-top: 0.1rem!important;">
            @if (!\App\Models\Follow::isFollowed(Auth::user()->id, $user->id))
                <form method="post" action="{{ route('follow.store', $user->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm" style="font-size: .675rem">Follow</button>
                </form>
            @endif
        </div>
    </div>
    @endforeach
@endif

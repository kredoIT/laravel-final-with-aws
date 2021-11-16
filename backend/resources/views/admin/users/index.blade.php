@extends('layouts.app')

@section('title', 'Users')

@section('content')

@if ($users->isNotEmpty())
    <table class="table table-hover table-striped align-middle">
        <thead>
            <th>#</th>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th width="9%">Status</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($user->avatar)
                        <img src="{{ App\Models\User::showAvatar($user->avatar) }}" class="rounded border border-1 rounded-circle " alt="..." style="height: 2.8rem; width: 3rem; " /> 
                    @else
                        <i class="far fa-user-circle fa-3x"></i>
                    @endif
                </td>
                <td>
                    <a href="{{ route('profile.show', $user->id) }}">
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <span class="{{ $user->trashed() ? 'text-danger' : 'text-dark' }}">
                        {{ $user->trashed() ? 'Non-Active' : 'Active' }}
                    </span>
                </td>
                <td>
                    @if (Auth::user()->id != $user->id)
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="text-center">
                                    <button 
                                        type="submit" 
                                        class="btn btn-block btn-sm dropdown-item" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="{{ $user->trashed() ? '#activateUser-' . $user->id : '#activateUser-' . $user->id }}"
                                    >
                                    
                                    @if ($user->trashed())
                                        <span class="text-primary">
                                            <i class="fas fa-user-check"></i> Activate
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            <i class="fas fa-user-slash"></i> Deactivate
                                        </span>
                                    @endif
                                    </button>
                                </li>
                            </ul>
                        </div>

                        @include('admin.users.modal.status', ['user' => $user])
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination.custom') }}
@endif
@endsection

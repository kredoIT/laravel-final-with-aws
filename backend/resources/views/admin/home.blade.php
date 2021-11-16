@extends('layouts.app')

@section('content')
@if ($users->isNotEmpty())
    <table class="table table-hover table-striped">
        <thead>
            <th>ID</th>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Status</th>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->avatar }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    Active / Non-Active 
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-success" href="#"><i class="fas fa-user-check"></i> Activate</a></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-user-slash"></i> Deactivate</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-sm"></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination.custom') }}
@endif
@endsection

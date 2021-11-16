@extends('layouts.app')

@section('title', 'Posts')

@section('content')

@if ($posts->isNotEmpty())
<div class="table-responsive">
    <table class="table table-hover table-striped table-sm align-middle">
        <thead>
            <th>#</th>
            <th>Image</th>
            <th>Category</th>
            <th>Owner</th>
            <th>Created at</th>
            <th>Status</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($post->image)
                        <img src="{{ App\Models\Post::showImage($post->image) }}" class="rounded border border-1  img-thumbnail" alt="..." style="height: 10rem; width: 15rem; " /> 
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </td>
                <td>
                    @foreach($post->categoryPost as $category)
                        <span class="badge bg-secondary">{{ $category->category->name ?? null }}</span>
                    @endforeach
                </td>
                <td>{{ $post->user->name  }}</td>
                <td>{{ $post->created_at }}</td>
                <td class="">
                    <span class="{{ $post->trashed() ? 'text-danger' : 'text-dark' }}">
                        {{ $post->trashed() ? 'Hidden' : 'Visible' }}
                    </span>
                </td>
                <td>
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
                                    data-bs-target="#postStatus-{{ $post->id }}"
                                >
                                
                                @if ($post->trashed())
                                    <span class="text-primary">
                                        <i class="fas fa-eye"></i> Display
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-eye-slash"></i> Hide
                                    </span>
                                @endif
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>

            @include('admin.posts.modal.status', ['post' => $post])
            @endforeach
        </tbody>
    </table>
    {{ $posts->links('pagination.custom') }}
</div>
@endif

@endsection

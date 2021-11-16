@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<form method="post" class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('admin.categories.store') }}">
    @csrf
    <div class="col-5">
        <input name="name" type="text" class="form-control" placeholder="Add Category" />
    </div>

    <div class="col-2">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@error('name')
    <p class="text-danger">{{ $message }}</p>
@enderror

@if ($categories->isNotEmpty())
<div class="table-responsive mt-3">

    <table class="table table-hover table-striped table-sm">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Posts</th>
            <th>Created at</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->categoryPosts()->count() }}</td>
                <td>{{ $category->created_at }}</td>
                <td>
                    <button
                        type="button" 
                        class="btn btn-primary btn-sm me-2"
                        data-bs-toggle="modal" 
                        data-bs-target="#categoryEdit-{{ $category->id }}"
                    ><i class="fas fa-edit"></i> </button>

                    <button 
                        type="button" 
                        class="btn btn-danger btn-sm"
                        data-bs-toggle="modal" 
                        data-bs-target="#categoryStatus-{{ $category->id }}"
                    ><i class="fas fa-trash-alt"></i> </button>
                </td>
            </tr>

            @include('admin.categories.modal.status', ['category' => $category])
            @include('admin.categories.modal.edit', ['category' => $category])
            @endforeach
        </tbody>
    </table>
    {{ $categories->links('pagination.custom') }}
</div>
@endif

@endsection

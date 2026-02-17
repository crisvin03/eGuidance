@extends('layouts.dashboard')

@section('title', 'Concern Categories')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Concern Categories</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="POST" action="{{ route('admin.categories.store') }}" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="New category name" required>
                    <input type="text" name="description" class="form-control" placeholder="Description (optional)">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Add Category
                    </button>
                </form>
            </div>
        </div>
        
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                                @csrf
                                @method('PUT')
                                <tr>
                                    <td>
                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                    </td>
                                    <td>
                                        <input type="text" name="description" class="form-control" value="{{ $category->description ?? '' }}">
                                    </td>
                                    <td>
                                        <select name="is_active" class="form-select">
                                            <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle"></i>
                                            Update
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-tags" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Categories Found</h4>
                <p class="text-muted">Add your first concern category to get started.</p>
            </div>
        @endif
    </div>
</div>
@endsection

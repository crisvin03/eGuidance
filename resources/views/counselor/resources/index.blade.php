@extends('layouts.dashboard')

@section('title', 'Teacher Resources Management')

@section('content')
@include('student.partials.modern-styles')

<style>
.resource-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    transition: all 0.2s ease;
}

.resource-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: var(--green);
}

.resource-category-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.resource-category-hrg { background: rgba(59, 130, 246, 0.1); color: #1e40af; }
.resource-category-handbook { background: rgba(16, 185, 129, 0.1); color: #047857; }
.resource-category-gender_dev { background: rgba(139, 92, 246, 0.1); color: #6d28d9; }

.file-type-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 600;
    text-transform: uppercase;
}

.file-type-pdf { background: #fee2e2; color: #dc2626; }
.file-type-doc, .file-type-docx { background: #dbeafe; color: #2563eb; }
.file-type-ppt, .file-type-pptx { background: #fed7d7; color: #e53e3e; }
.file-type-jpg, .file-type-jpeg, .file-type-png { background: #d1fae5; color: #059669; }
.file-type-default { background: #f3f4f6; color: #6b7280; }

@media (max-width: 768px) {
    .resource-grid { grid-template-columns: 1fr !important; }
    .resource-filters { flex-direction: column !important; gap: 1rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-folder-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Teacher Resources Management</h1>
            <p class="modern-page-subtitle">Upload and manage resources for teachers</p>
        </div>
        <a href="{{ route('counselor.resources.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-plus-circle"></i> Upload Resource
        </a>
    </div>
</div>

<!-- Filters -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" action="{{ route('counselor.resources.index') }}" class="resource-filters" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Search Resources</label>
            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by title or description..." style="border-radius: 10px;">
        </div>
        
        <div style="min-width: 150px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Category</label>
            <select class="form-control" name="category" style="border-radius: 10px;">
                <option value="">All Categories</option>
                <option value="hrg" {{ request('category') === 'hrg' ? 'selected' : '' }}>Home Room Guidance</option>
                <option value="handbook" {{ request('category') === 'handbook' ? 'selected' : '' }}>Handbook & Policies</option>
                <option value="gender_dev" {{ request('category') === 'gender_dev' ? 'selected' : '' }}>Gender & Development</option>
            </select>
        </div>
        
        <div style="min-width: 120px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select class="form-control" name="status" style="border-radius: 10px;">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-search"></i> Filter
            </button>
            <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>
</div>

@if($resources->count() > 0)
    <!-- Resources Grid -->
    <div class="resource-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        @foreach($resources as $resource)
            <div class="resource-card">
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div class="file-type-icon file-type-{{ strtolower($resource->file_type) }}">
                        {{ strtoupper($resource->file_type) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: start; justify-content: between; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0; line-height: 1.3; word-break: break-word;">
                                {{ $resource->title }}
                            </h3>
                            <div class="dropdown">
                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" style="border: none; color: var(--text-muted); padding: 0.25rem;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                    <li><a class="dropdown-item" href="{{ route('counselor.resources.show', $resource) }}"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                    <li><a class="dropdown-item" href="{{ route('counselor.resources.download', $resource) }}"><i class="bi bi-download me-2"></i>Download</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item toggle-status" 
                                                data-id="{{ $resource->id }}"
                                                data-status="{{ $resource->is_active ? 'deactivate' : 'activate' }}">
                                            <i class="bi bi-{{ $resource->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                            {{ $resource->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </li>
                                    <li>
                                        <form action="{{ route('counselor.resources.destroy', $resource) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <span class="resource-category-badge resource-category-{{ $resource->category }}">
                            {{ $resource->category_label }}
                        </span>
                    </div>
                </div>
                
                @if($resource->description)
                    <p style="color: var(--text-muted); font-size: 0.875rem; line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($resource->description, 100) }}
                    </p>
                @endif
                
                <div style="display: flex; align-items: center; justify-content: between; text-align: center; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">
                        <div style="font-weight: 600;">{{ $resource->formatted_file_size }}</div>
                        <div>{{ $resource->created_at->format('M j, Y') }}</div>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); text-align: right;">
                        <div style="font-weight: 600;">Uploaded by</div>
                        <div>{{ $resource->uploader->name }}</div>
                    </div>
                    <div>
                        @if($resource->is_active)
                            <span class="modern-badge modern-badge-success" style="font-size: 0.7rem;">Active</span>
                        @else
                            <span class="modern-badge modern-badge-secondary" style="font-size: 0.7rem;">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($resources->hasPages())
        <div class="d-flex justify-content-center">
            {{ $resources->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="modern-card text-center" style="padding: 3rem;">
        <div class="modern-page-icon" style="width: 80px; height: 80px; font-size: 2rem; background: rgba(107, 114, 128, 0.1); color: var(--text-muted); margin: 0 auto 1.5rem;">
            <i class="bi bi-folder-x"></i>
        </div>
        <h3 style="color: var(--navy); font-weight: 700; margin-bottom: 0.5rem;">No Resources Found</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">
            @if(request()->hasAny(['search', 'category', 'status']))
                Try adjusting your filters or <a href="{{ route('counselor.resources.index') }}" class="text-decoration-none" style="color: var(--green);">clear all filters</a>.
            @else
                Start by uploading your first resource for teachers.
            @endif
        </p>
        <a href="{{ route('counselor.resources.create') }}" class="modern-btn modern-btn-primary">
            <i class="bi bi-plus-circle"></i> Upload First Resource
        </a>
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle resource status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const resourceId = this.dataset.id;
            const action = this.dataset.status;
            
            if (confirm(`Are you sure you want to ${action} this resource?`)) {
                fetch(`/counselor/resources/${resourceId}/toggle-status`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update resource status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update resource status');
                });
            }
        });
    });
    
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this resource? This action cannot be undone.')) {
                this.submit();
            }
        });
    });
});
</script>
@endpush
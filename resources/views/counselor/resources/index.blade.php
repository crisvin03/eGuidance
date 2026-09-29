@extends('layouts.dashboard')

@section('title', 'Resource Management')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-folder-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Resource Management</h1>
            <p class="modern-page-subtitle">Manage resources for teachers and students</p>
        </div>
        <a href="{{ route('counselor.resources.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-plus-circle"></i>
            <span>Upload Resource</span>
        </a>
    </div>
</div>

<!-- Filters -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" action="{{ route('counselor.resources.index') }}" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <label class="modern-form-label">Search Resources</label>
            <input type="text" class="form-control modern-form-control" name="search" value="{{ request('search') }}" placeholder="Search by title or description...">
        </div>
        
        <div style="min-width: 180px;">
            <label class="modern-form-label">Category</label>
            <select class="form-control modern-form-control" name="category">
                <option value="">All Categories</option>
                <optgroup label="For Teachers">
                    <option value="hrg" {{ request('category') === 'hrg' ? 'selected' : '' }}>Home Room Guidance</option>
                    <option value="handbook" {{ request('category') === 'handbook' ? 'selected' : '' }}>Handbook & Policies</option>
                    <option value="gender_dev" {{ request('category') === 'gender_dev' ? 'selected' : '' }}>Gender & Development</option>
                </optgroup>
                <optgroup label="For Students">
                    <option value="future_me" {{ request('category') === 'future_me' ? 'selected' : '' }}>Future Me (Career)</option>
                </optgroup>
            </select>
        </div>
        
        <div style="min-width: 150px;">
            <label class="modern-form-label">Status</label>
            <select class="form-control modern-form-control" name="status">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-search"></i>
                <span>Filter</span>
            </button>
            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i>
                    <span>Clear</span>
                </a>
            @endif
        </div>
    </form>
</div>

@if($resources->count() > 0)
    <!-- Resources Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        @foreach($resources as $resource)
            <div class="modern-card" style="padding: 1.25rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
                <!-- Header -->
                <div style="display: flex; align-items: start; justify-content: space-between; gap: 1rem; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: start; gap: 1rem; flex: 1; min-width: 0;">
                        @php
                            $fileTypeColors = [
                                'pdf' => ['bg' => '#fee2e2', 'color' => '#dc2626'],
                                'doc' => ['bg' => '#dbeafe', 'color' => '#2563eb'],
                                'docx' => ['bg' => '#dbeafe', 'color' => '#2563eb'],
                                'ppt' => ['bg' => '#fed7aa', 'color' => '#ea580c'],
                                'pptx' => ['bg' => '#fed7aa', 'color' => '#ea580c'],
                                'xls' => ['bg' => '#d1fae5', 'color' => '#059669'],
                                'xlsx' => ['bg' => '#d1fae5', 'color' => '#059669'],
                            ];
                            $fileType = strtolower($resource->file_type);
                            $typeStyle = $fileTypeColors[$fileType] ?? ['bg' => '#f3f4f6', 'color' => '#6b7280'];
                        @endphp
                        <div style="width: 48px; height: 48px; border-radius: 10px; background: {{ $typeStyle['bg'] }}; color: {{ $typeStyle['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; flex-shrink: 0;">
                            {{ strtoupper($resource->file_type) }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3; word-break: break-word;">
                                {{ $resource->title }}
                            </h6>
                            <div style="font-size: 0.75rem; margin-bottom: 0.5rem;">
                                <span class="modern-badge modern-badge-{{ $resource->category === 'future_me' ? 'secondary' : 'info' }}" style="font-size: 0.7rem;">
                                    {{ $resource->category_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Toggle -->
                    <div>
                        <span class="modern-badge modern-badge-{{ $resource->is_active ? 'success' : 'secondary' }}" style="font-size: 0.75rem;">
                            {{ $resource->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                
                <!-- Description -->
                @if($resource->description)
                    <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($resource->description, 100) }}
                    </p>
                @endif
                
                <!-- Meta -->
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0, 0, 0, 0.06); font-size: 0.8rem; color: var(--text-muted);">
                    <div style="display: flex; align-items: center; gap: 0.375rem;">
                        <i class="bi bi-hdd"></i>
                        <span>{{ $resource->formatted_file_size }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.375rem;">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ $resource->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('counselor.resources.show', $resource) }}" 
                       class="modern-btn modern-btn-primary" 
                       style="flex: 1; justify-content: center; padding: 0.625rem; font-size: 0.85rem;">
                        <i class="bi bi-eye"></i>
                        <span>View</span>
                    </a>
                    <form action="{{ route('counselor.resources.destroy', $resource) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modern-btn modern-btn-outline" style="width: 100%; justify-content: center; padding: 0.625rem; font-size: 0.85rem; color: #dc2626; border-color: #dc2626;">
                            <i class="bi bi-trash"></i>
                            <span>Delete</span>
                        </button>
                    </form>
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
    <div class="modern-card" style="padding: 3rem; text-align: center;">
        <i class="bi bi-inbox" style="font-size: 3.5rem; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
            @if(request()->hasAny(['search', 'category', 'status']))
                No Resources Found
            @else
                No Resources Yet
            @endif
        </h3>
        <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 2rem;">
            @if(request()->hasAny(['search', 'category', 'status']))
                No resources match your filters. Try adjusting your search criteria.
            @else
                Start by uploading your first resource for teachers.
            @endif
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="bi bi-x-circle"></i>
                    <span>Clear Filters</span>
                </a>
            @endif
            <a href="{{ route('counselor.resources.create') }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-plus-circle"></i>
                <span>Upload Resource</span>
            </a>
        </div>
    </div>
@endif

<style>
@media (max-width: 768px) {
    .modern-page-header-compact {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    
    .modern-page-header-compact > a {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

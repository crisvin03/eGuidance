@extends('layouts.dashboard')

@section('title', $categoryTitle . ' Resources')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            @if(str_contains(strtolower($categoryTitle), 'hrg'))
                <i class="bi bi-house-heart-fill"></i>
            @elseif(str_contains(strtolower($categoryTitle), 'handbook'))
                <i class="bi bi-journal-text"></i>
            @else
                <i class="bi bi-people-fill"></i>
            @endif
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">{{ $categoryTitle }}</h1>
            <p class="modern-page-subtitle">Browse and download teaching materials</p>
        </div>
        <a href="{{ route('teacher.resources') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i>
            <span>Back</span>
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <label class="modern-form-label">Search Resources</label>
            <input type="text" class="form-control modern-form-control" name="search" value="{{ request('search') }}" 
                   placeholder="Search by title or description...">
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-search"></i>
                <span>Search</span>
            </button>
            @if(request('search'))
                <a href="{{ request()->url() }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i>
                    <span>Clear</span>
                </a>
            @endif
        </div>
    </form>
</div>

@if($resources->count() > 0)
    <!-- Resources Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        @foreach($resources as $resource)
            <div class="modern-card" style="padding: 1.25rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'; this.style.borderColor='var(--green)';" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='';">
                <!-- Header -->
                <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                    @php
                        $fileTypeColors = [
                            'pdf' => ['bg' => '#fee2e2', 'color' => '#dc2626'],
                            'doc' => ['bg' => '#dbeafe', 'color' => '#2563eb'],
                            'docx' => ['bg' => '#dbeafe', 'color' => '#2563eb'],
                            'ppt' => ['bg' => '#fed7aa', 'color' => '#ea580c'],
                            'pptx' => ['bg' => '#fed7aa', 'color' => '#ea580c'],
                            'xls' => ['bg' => '#d1fae5', 'color' => '#059669'],
                            'xlsx' => ['bg' => '#d1fae5', 'color' => '#059669'],
                            'jpg' => ['bg' => '#fce7f3', 'color' => '#db2777'],
                            'jpeg' => ['bg' => '#fce7f3', 'color' => '#db2777'],
                            'png' => ['bg' => '#fce7f3', 'color' => '#db2777'],
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
                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-person-circle"></i>
                            {{ $resource->uploader->name }}
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                @if($resource->description)
                    <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($resource->description, 100) }}
                    </p>
                @endif
                
                <!-- Meta Info -->
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0, 0, 0, 0.06);">
                    <div style="flex: 1;">
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">File Size</div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--navy);">{{ $resource->formatted_file_size }}</div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Uploaded</div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--navy);">{{ $resource->created_at->format('M j, Y') }}</div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('teacher.resources.download', $resource) }}" 
                       class="modern-btn modern-btn-primary" 
                       style="flex: 1; justify-content: center; padding: 0.75rem; font-size: 0.9rem;">
                        <i class="bi bi-download"></i>
                        <span>Download</span>
                    </a>
                    <a href="{{ Storage::url($resource->file_path) }}" 
                       target="_blank"
                       class="modern-btn modern-btn-secondary" 
                       style="padding: 0.75rem; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($resources->hasPages())
        <div class="d-flex justify-content-center mb-4">
            {{ $resources->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="modern-card" style="padding: 3rem; text-align: center;">
        <i class="bi bi-inbox" style="font-size: 3.5rem; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
            @if(request('search'))
                No Results Found
            @else
                No Resources Yet
            @endif
        </h3>
        <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
            @if(request('search'))
                No resources found matching "<strong>{{ request('search') }}</strong>". Try a different search term or clear the search to see all resources.
            @else
                No {{ strtolower($categoryTitle) }} resources have been uploaded yet. Check back later or contact the guidance office.
            @endif
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @if(request('search'))
                <a href="{{ request()->url() }}" class="modern-btn modern-btn-secondary">
                    <i class="bi bi-x-circle"></i>
                    <span>Clear Search</span>
                </a>
            @endif
            <a href="{{ route('teacher.resources') }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-grid"></i>
                <span>Browse Categories</span>
            </a>
            <a href="{{ route('teacher.talk-to-counselor') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-chat-dots"></i>
                <span>Request Resources</span>
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

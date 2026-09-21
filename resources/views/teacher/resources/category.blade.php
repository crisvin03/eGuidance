@extends('layouts.dashboard')

@section('title', $categoryTitle . ' Resources')

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
    .resources-grid { grid-template-columns: 1fr !important; }
    .resources-filters { flex-direction: column !important; gap: 1rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(4, 120, 87, 0.12)); color: #10b981;">
            @if(str_contains(strtolower($categoryTitle), 'hrg'))
                <i class="bi bi-house-heart-fill"></i>
            @elseif(str_contains(strtolower($categoryTitle), 'handbook'))
                <i class="bi bi-shield-check-fill"></i>
            @elseif(str_contains(strtolower($categoryTitle), 'gender'))
                <i class="bi bi-people-fill"></i>
            @else
                <i class="bi bi-folder-fill"></i>
            @endif
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">{{ $categoryTitle }} Resources</h1>
            <p class="modern-page-subtitle">Browse and download materials for your teaching practice</p>
        </div>
        <a href="{{ route('teacher.resources') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<!-- Search Filter -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" class="resources-filters" style="display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1; min-width: 300px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Search Resources</label>
            <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                   placeholder="Search by title or description..." style="border-radius: 10px;">
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-search"></i> Search
            </button>
            <a href="{{ request()->url() }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-arrow-clockwise"></i> Clear
            </a>
        </div>
    </form>
</div>

@if($resources->count() > 0)
    <!-- Resources Grid -->
    <div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        @foreach($resources as $resource)
            <div class="resource-card">
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div class="file-type-icon file-type-{{ strtolower($resource->file_type) }}">
                        {{ strtoupper($resource->file_type) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3; word-break: break-word;">
                            {{ $resource->title }}
                        </h3>
                        <div style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                            <i class="bi bi-person-fill me-1"></i>
                            Uploaded by {{ $resource->uploader->name }}
                        </div>
                    </div>
                </div>
                
                @if($resource->description)
                    <p style="color: var(--text-muted); font-size: 0.875rem; line-height: 1.5; margin-bottom: 1rem;">
                        {{ $resource->description }}
                    </p>
                @endif
                
                <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                    <div style="display: flex; gap: 1rem; font-size: 0.75rem; color: var(--text-muted);">
                        <div>
                            <div style="font-weight: 600;">File Size</div>
                            <div>{{ $resource->formatted_file_size }}</div>
                        </div>
                        <div>
                            <div style="font-weight: 600;">Uploaded</div>
                            <div>{{ $resource->created_at->format('M j, Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('teacher.resources.download', $resource) }}" 
                       class="modern-btn modern-btn-primary" 
                       style="flex: 1; justify-content: center; padding: 0.75rem;">
                        <i class="bi bi-download"></i> Download
                    </a>
                    
                    <button type="button" class="modern-btn modern-btn-outline resource-preview" 
                            data-resource="{{ $resource->id }}"
                            style="padding: 0.75rem;">
                        <i class="bi bi-eye"></i>
                    </button>
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
            @if(request('search'))
                No resources found matching "{{ request('search') }}". <a href="{{ request()->url() }}" class="text-decoration-none" style="color: var(--green);">Clear search</a> to see all resources.
            @else
                No {{ strtolower($categoryTitle) }} resources have been uploaded yet.
            @endif
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('teacher.resources') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i> Browse Other Categories
            </a>
            <a href="{{ route('teacher.talk-to-counselor') }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-chat-dots"></i> Request Resources
            </a>
        </div>
    </div>
@endif

<!-- Resource Preview Modal -->
<div class="modal fade" id="resourcePreviewModal" tabindex="-1" aria-labelledby="resourcePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h5 class="modal-title" id="resourcePreviewModalLabel" style="font-weight: 700; color: var(--navy);">
                    <i class="bi bi-eye me-2" style="color: var(--green);"></i>Resource Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="resourcePreviewContent" style="padding: 1.5rem;">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewModal = new bootstrap.Modal(document.getElementById('resourcePreviewModal'));
    const previewContent = document.getElementById('resourcePreviewContent');
    
    // Resource preview handlers
    document.querySelectorAll('.resource-preview').forEach(button => {
        button.addEventListener('click', function() {
            const resourceId = this.dataset.resource;
            
            // Show loading state
            previewContent.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-success mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>Loading resource information...</div>
                </div>
            `;
            
            previewModal.show();
            
            // In a real implementation, you would fetch resource details via AJAX
            // For now, we'll show basic info
            setTimeout(() => {
                previewContent.innerHTML = `
                    <div class="text-center py-4">
                        <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h4 style="color: var(--navy); margin-bottom: 1rem;">Resource Preview</h4>
                        <p style="color: var(--text-muted); margin-bottom: 2rem;">
                            This resource is available for download. Click the download button to access the full content.
                        </p>
                        <div style="display: flex; gap: 1rem; justify-content: center;">
                            <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="modern-btn modern-btn-primary" onclick="window.location.href='#'">
                                <i class="bi bi-download"></i> Download Resource
                            </button>
                        </div>
                    </div>
                `;
            }, 1000);
        });
    });
});
</script>
@endpush
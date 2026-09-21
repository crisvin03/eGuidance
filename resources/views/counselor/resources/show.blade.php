@extends('layouts.dashboard')

@section('title', 'Resource Details')

@section('content')
@include('student.partials.modern-styles')

<style>
.resource-header {
    background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
}

.resource-details-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 2rem;
}

.resource-meta {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
}

.resource-meta-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.resource-meta-item:last-child {
    border-bottom: none;
}

.file-preview-card {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.2s ease;
}

.file-preview-card:hover {
    border-color: var(--green);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.category-badge-large {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-hrg { background: rgba(59, 130, 246, 0.1); color: #1e40af; }
.category-handbook { background: rgba(16, 185, 129, 0.1); color: #047857; }
.category-gender_dev { background: rgba(139, 92, 246, 0.1); color: #6d28d9; }

@media (max-width: 1024px) {
    .resource-details-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    .resource-header { padding: 1.5rem; }
}

@media (max-width: 768px) {
    .resource-actions { 
        flex-direction: column !important; 
        align-items: stretch !important;
    }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-file-earmark-text-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Resource Details</h1>
            <p class="modern-page-subtitle">View and manage resource information</p>
        </div>
        <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i> Back to Resources
        </a>
    </div>
</div>

<div class="resource-details-grid">
    <!-- Main Content -->
    <div>
        <!-- Resource Header -->
        <div class="resource-header">
            <div style="display: flex; align-items: start; justify-content: between; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="flex: 1;">
                    <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; line-height: 1.2;">
                        {{ $resource->title }}
                    </h1>
                    <div class="category-badge-large category-{{ $resource->category }}">
                        {{ $resource->category_label }}
                    </div>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    @if($resource->is_active)
                        <span class="badge" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem;">
                            <i class="bi bi-eye me-1"></i>Active
                        </span>
                    @else
                        <span class="badge" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem;">
                            <i class="bi bi-eye-slash me-1"></i>Inactive
                        </span>
                    @endif
                </div>
            </div>
            
            @if($resource->description)
                <p style="font-size: 1rem; line-height: 1.6; margin: 0; opacity: 0.95;">
                    {{ $resource->description }}
                </p>
            @endif
        </div>
        
        <!-- File Preview -->
        <div class="modern-card" style="padding: 0;">
            <div class="file-preview-card">
                <div style="margin-bottom: 1.5rem;">
                    @php
                        $fileIcon = match(strtolower($resource->file_type)) {
                            'pdf' => 'bi-file-earmark-pdf-fill text-danger',
                            'doc', 'docx' => 'bi-file-earmark-word-fill text-primary',
                            'ppt', 'pptx' => 'bi-file-earmark-ppt-fill text-warning',
                            'jpg', 'jpeg', 'png' => 'bi-file-earmark-image-fill text-success',
                            default => 'bi-file-earmark text-muted'
                        };
                    @endphp
                    <i class="bi {{ $fileIcon }}" style="font-size: 4rem;"></i>
                </div>
                
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">
                    {{ $resource->file_name }}
                </h3>
                
                <div style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 2rem; font-size: 0.875rem; color: var(--text-muted);">
                    <div>
                        <strong>Type:</strong> {{ strtoupper($resource->file_type) }}
                    </div>
                    <div>
                        <strong>Size:</strong> {{ $resource->formatted_file_size }}
                    </div>
                </div>
                
                <div class="resource-actions" style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="{{ route('counselor.resources.download', $resource) }}" 
                       class="modern-btn modern-btn-primary" style="padding: 0.75rem 2rem;">
                        <i class="bi bi-download"></i> Download File
                    </a>
                    
                    <button type="button" class="modern-btn modern-btn-secondary toggle-status" 
                            data-id="{{ $resource->id }}"
                            data-status="{{ $resource->is_active ? 'deactivate' : 'activate' }}"
                            style="padding: 0.75rem 2rem;">
                        <i class="bi bi-{{ $resource->is_active ? 'eye-slash' : 'eye' }}"></i>
                        {{ $resource->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                    
                    <form action="{{ route('counselor.resources.destroy', $resource) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modern-btn" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 0.75rem 2rem;">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div>
        <!-- Resource Metadata -->
        <div class="modern-card" style="padding: 0; margin-bottom: 1.5rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--navy); margin: 0;">
                    <i class="bi bi-info-circle me-2" style="color: var(--green);"></i>
                    Resource Information
                </h3>
            </div>
            <div class="resource-meta">
                <div class="resource-meta-item">
                    <span style="font-weight: 600; color: var(--navy);">Uploaded By</span>
                    <span style="color: var(--text-muted);">{{ $resource->uploader->name }}</span>
                </div>
                <div class="resource-meta-item">
                    <span style="font-weight: 600; color: var(--navy);">Upload Date</span>
                    <span style="color: var(--text-muted);">{{ $resource->created_at->format('M j, Y \a\t g:i A') }}</span>
                </div>
                <div class="resource-meta-item">
                    <span style="font-weight: 600; color: var(--navy);">Last Modified</span>
                    <span style="color: var(--text-muted);">{{ $resource->updated_at->format('M j, Y \a\t g:i A') }}</span>
                </div>
                <div class="resource-meta-item">
                    <span style="font-weight: 600; color: var(--navy);">Status</span>
                    @if($resource->is_active)
                        <span class="modern-badge modern-badge-success">Active</span>
                    @else
                        <span class="modern-badge modern-badge-secondary">Inactive</span>
                    @endif
                </div>
                <div class="resource-meta-item">
                    <span style="font-weight: 600; color: var(--navy);">Category</span>
                    <span style="color: var(--text-muted);">{{ $resource->category_label }}</span>
                </div>
                <div class="resource-meta-item">
                    <span style="font-weight: 600; color: var(--navy);">File Size</span>
                    <span style="color: var(--text-muted);">{{ $resource->formatted_file_size }}</span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h4 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
                <i class="bi bi-lightning me-2" style="color: var(--green);"></i>
                Quick Actions
            </h4>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('counselor.resources.download', $resource) }}" 
                   class="modern-btn modern-btn-outline" style="justify-content: start; text-align: left;">
                    <i class="bi bi-download me-2"></i> Download File
                </a>
                
                <button type="button" class="modern-btn modern-btn-outline toggle-status" 
                        data-id="{{ $resource->id }}"
                        data-status="{{ $resource->is_active ? 'deactivate' : 'activate' }}"
                        style="justify-content: start; text-align: left;">
                    <i class="bi bi-{{ $resource->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                    {{ $resource->is_active ? 'Deactivate Resource' : 'Activate Resource' }}
                </button>
                
                <a href="{{ route('counselor.resources.index') }}" 
                   class="modern-btn modern-btn-outline" style="justify-content: start; text-align: left;">
                    <i class="bi bi-list me-2"></i> View All Resources
                </a>
                
                <a href="{{ route('counselor.resources.create') }}" 
                   class="modern-btn modern-btn-outline" style="justify-content: start; text-align: left;">
                    <i class="bi bi-plus-circle me-2"></i> Upload New Resource
                </a>
            </div>
        </div>
    </div>
</div>
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
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                this.disabled = true;
                
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
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update resource status');
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            }
        });
    });
    
    // Delete confirmation
    document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this resource? This action cannot be undone and will remove the file from the system.')) {
            this.submit();
        }
    });
});
</script>
@endpush
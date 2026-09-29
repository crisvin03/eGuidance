@extends('layouts.dashboard')

@section('title', 'Resource Details')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 320px"] { display: block !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-btn { width: 100% !important; justify-content: center !important; }
    div[style*="display: flex"][style*="gap"] { flex-direction: column !important; }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left me-2"></i>Back to Resources
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <!-- Resource Details Card -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb;">
                <div style="flex: 1;">
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--navy); margin: 0 0 0.75rem 0;">{{ $resource->title }}</h1>
                    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                        @if($resource->is_active)
                            <span class="modern-badge modern-badge-success"><i class="bi bi-eye-fill"></i> Active</span>
                        @else
                            <span class="modern-badge modern-badge-secondary"><i class="bi bi-eye-slash-fill"></i> Inactive</span>
                        @endif
                        
                        @php
                            $categoryBadge = match($resource->category) {
                                'hrg' => 'info',
                                'handbook' => 'success',
                                'gender_dev' => 'warning',
                                'future_me' => 'primary',
                                default => 'secondary'
                            };
                            $categoryIcon = match($resource->category) {
                                'hrg' => 'book',
                                'handbook' => 'journal-text',
                                'gender_dev' => 'gender-ambiguous',
                                'future_me' => 'compass',
                                default => 'folder'
                            };
                        @endphp
                        <span class="modern-badge modern-badge-{{ $categoryBadge }}"><i class="bi bi-{{ $categoryIcon }}"></i> {{ $resource->category_label }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Uploaded By</div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="modern-section-icon" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.8rem; font-weight: 700;">
                            {{ strtoupper(substr($resource->uploader->name, 0, 2)) }}
                        </div>
                        <strong style="color: var(--navy);">{{ $resource->uploader->name }}</strong>
                    </div>
                </div>

                <div style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                        <i class="bi bi-calendar"></i> Uploaded
                    </div>
                    <strong style="color: var(--navy);">{{ $resource->created_at->format('M d, Y h:i A') }}</strong>
                </div>
            </div>

            <!-- Description -->
            @if($resource->description)
            <div style="margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
                    <i class="bi bi-text-paragraph me-2"></i>Description
                </h6>
                <p style="margin: 0; color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $resource->description }}</p>
            </div>
            @endif

            <!-- File Preview -->
            <div style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.05), rgba(30, 122, 74, 0.02)); border: 2px dashed rgba(30, 122, 74, 0.2); border-radius: 12px; padding: 2rem; text-align: center; margin-bottom: 1.5rem;">
                @php
                    $fileIcon = match(strtolower($resource->file_type)) {
                        'pdf' => 'bi-file-earmark-pdf-fill text-danger',
                        'doc', 'docx' => 'bi-file-earmark-word-fill text-primary',
                        'ppt', 'pptx' => 'bi-file-earmark-ppt-fill text-warning',
                        'jpg', 'jpeg', 'png' => 'bi-file-earmark-image-fill text-success',
                        default => 'bi-file-earmark text-muted'
                    };
                @endphp
                <i class="bi {{ $fileIcon }}" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">{{ $resource->file_name }}</h4>
                <div style="display: flex; justify-content: center; gap: 1.5rem; font-size: 0.875rem; color: var(--text-muted);">
                    <span><strong>Type:</strong> {{ strtoupper($resource->file_type) }}</span>
                    <span><strong>Size:</strong> {{ $resource->formatted_file_size }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="{{ route('counselor.resources.download', $resource) }}" 
                   class="modern-btn modern-btn-primary" style="flex: 1; justify-content: center; min-width: 150px;">
                    <i class="bi bi-download"></i> Download
                </a>
                
                <button type="button" class="modern-btn modern-btn-secondary toggle-status" 
                        data-id="{{ $resource->id }}"
                        data-status="{{ $resource->is_active ? 'deactivate' : 'activate' }}"
                        style="flex: 1; justify-content: center; min-width: 150px;">
                    <i class="bi bi-{{ $resource->is_active ? 'eye-slash' : 'eye' }}"></i>
                    {{ $resource->is_active ? 'Deactivate' : 'Activate' }}
                </button>
                
                <form action="{{ route('counselor.resources.destroy', $resource) }}" method="POST" class="delete-form" style="flex: 1; min-width: 150px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modern-btn modern-btn-outline" style="width: 100%; justify-content: center; color: #dc2626; border-color: #dc2626;">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Resource Info -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
                <i class="bi bi-info-circle me-2" style="color: var(--green);"></i>Resource Info
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Status</div>
                    @if($resource->is_active)
                        <span class="modern-badge modern-badge-success">Active</span>
                    @else
                        <span class="modern-badge modern-badge-secondary">Inactive</span>
                    @endif
                </div>
                
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Category</div>
                    <strong style="color: var(--navy); font-size: 0.9rem;">{{ $resource->category_label }}</strong>
                </div>
                
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">File Size</div>
                    <strong style="color: var(--navy); font-size: 0.9rem;">{{ $resource->formatted_file_size }}</strong>
                </div>
                
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Last Modified</div>
                    <strong style="color: var(--navy); font-size: 0.9rem;">{{ $resource->updated_at->format('M d, Y') }}</strong>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h4 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
                <i class="bi bi-lightning me-2" style="color: var(--green);"></i>Quick Actions
            </h4>
            
            <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                <a href="{{ route('counselor.resources.index') }}" 
                   class="modern-btn modern-btn-outline" style="justify-content: start; font-size: 0.875rem;">
                    <i class="bi bi-list me-2"></i> All Resources
                </a>
                
                <a href="{{ route('counselor.resources.create') }}" 
                   class="modern-btn modern-btn-outline" style="justify-content: start; font-size: 0.875rem;">
                    <i class="bi bi-plus-circle me-2"></i> Upload New
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
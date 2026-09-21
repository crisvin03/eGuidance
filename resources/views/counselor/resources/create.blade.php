@extends('layouts.dashboard')

@section('title', 'Upload Resource')

@section('content')
@include('student.partials.modern-styles')

<style>
.upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 3rem 2rem;
    text-align: center;
    background: #f9fafb;
    transition: all 0.2s ease;
    cursor: pointer;
}

.upload-zone:hover,
.upload-zone.dragover {
    border-color: var(--green);
    background: rgba(30, 122, 74, 0.05);
}

.upload-zone input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-preview {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
    display: none;
}

.category-info {
    background: #f8fafc;
    border-left: 4px solid var(--green);
    padding: 1rem 1.25rem;
    border-radius: 0 8px 8px 0;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .upload-zone { padding: 2rem 1rem; }
    .modern-form-grid { grid-template-columns: 1fr !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-cloud-upload-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Upload Teacher Resource</h1>
            <p class="modern-page-subtitle">Share resources with teachers across different categories</p>
        </div>
        <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left me-2"></i>Back to Resources
        </a>
    </div>
</div>

<div class="modern-card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <form action="{{ route('counselor.resources.store') }}" method="POST" enctype="multipart/form-data" id="resourceForm">
        @csrf
        
        <!-- Resource Details -->
        <div class="modern-form-section mb-4">
            <div class="modern-section-header mb-3">
                <div class="modern-section-icon modern-page-icon-green">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div>
                    <h3 class="modern-section-title">Resource Information</h3>
                    <p class="modern-section-subtitle">Provide details about the resource</p>
                </div>
            </div>
            
            <div class="modern-form-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                <div>
                    <label class="form-label fw-semibold" style="color: var(--navy);">
                        <i class="bi bi-chat-dots me-2"></i>Resource Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           name="title" value="{{ old('title') }}" required
                           placeholder="Enter a clear, descriptive title for this resource"
                           style="border-radius: 10px;">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label fw-semibold" style="color: var(--navy);">
                        <i class="bi bi-tag me-2"></i>Category <span class="text-danger">*</span>
                    </label>
                    <select class="form-control @error('category') is-invalid @enderror" 
                            name="category" required style="border-radius: 10px;" id="categorySelect">
                        <option value="">Select a category</option>
                        <option value="hrg" {{ old('category') === 'hrg' ? 'selected' : '' }}>Home Room Guidance (HRG)</option>
                        <option value="handbook" {{ old('category') === 'handbook' ? 'selected' : '' }}>Handbook & Policies</option>
                        <option value="gender_dev" {{ old('category') === 'gender_dev' ? 'selected' : '' }}>Gender and Development Corner</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Category Information -->
                    <div class="category-info" id="categoryInfo" style="display: none;">
                        <div id="categoryDescription"></div>
                    </div>
                </div>
                
                <div>
                    <label class="form-label fw-semibold" style="color: var(--navy);">
                        <i class="bi bi-text-paragraph me-2"></i>Description <span style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">(Optional)</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              name="description" rows="4"
                              placeholder="Provide additional details about this resource, its purpose, and how teachers can use it..."
                              style="border-radius: 10px;">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- File Upload -->
        <div class="modern-form-section mb-4">
            <div class="modern-section-header mb-3">
                <div class="modern-section-icon modern-page-icon-green">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                </div>
                <div>
                    <h3 class="modern-section-title">Upload File</h3>
                    <p class="modern-section-subtitle">Maximum file size: 10MB. Supported formats: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG</p>
                </div>
            </div>
            
            <div class="upload-zone" id="uploadZone">
                <input type="file" class="@error('file') is-invalid @enderror" 
                       name="file" id="fileInput" required 
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png">
                <div class="upload-content">
                    <div style="font-size: 3rem; color: var(--green); margin-bottom: 1rem;">
                        <i class="bi bi-cloud-upload"></i>
                    </div>
                    <h4 style="color: var(--navy); font-weight: 700; margin-bottom: 0.5rem;">Drop your file here or click to browse</h4>
                    <p style="color: var(--text-muted); font-size: 0.875rem;">
                        Supports: PDF, Word Documents, PowerPoint, Images
                    </p>
                </div>
            </div>
            
            @error('file')
                <div class="text-danger mt-2" style="font-size: 0.875rem;">{{ $message }}</div>
            @enderror
            
            <!-- File Preview -->
            <div class="file-preview" id="filePreview">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="file-icon" style="width: 48px; height: 48px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--navy);">
                        <i class="bi bi-file-earmark"></i>
                    </div>
                    <div style="flex: 1;">
                        <div class="file-name" style="font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;"></div>
                        <div class="file-details" style="font-size: 0.875rem; color: var(--text-muted);"></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeFile">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Submit Actions -->
        <div class="modern-form-actions" style="display: flex; gap: 1rem; justify-content: end; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
            <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </a>
            <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                <i class="bi bi-check-circle me-2"></i>Upload Resource
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const categorySelect = document.getElementById('categorySelect');
    const categoryInfo = document.getElementById('categoryInfo');
    const categoryDescription = document.getElementById('categoryDescription');
    const submitBtn = document.getElementById('submitBtn');
    
    const categoryDescriptions = {
        'hrg': {
            title: 'Home Room Guidance (HRG)',
            description: 'Resources for classroom guidance activities, lesson plans for homeroom periods, student development materials, and guidance curriculum resources.'
        },
        'handbook': {
            title: 'Handbook & Policies',
            description: 'School policies, disciplinary guidelines, student handbook materials, safety protocols, and administrative procedures that teachers need to reference.'
        },
        'gender_dev': {
            title: 'Gender and Development Corner',
            description: 'Gender-sensitive teaching materials, anti-discrimination resources, LGBTQ+ awareness guides, and inclusive classroom management strategies.'
        }
    };
    
    // Category selection handler
    categorySelect.addEventListener('change', function() {
        const selected = this.value;
        if (selected && categoryDescriptions[selected]) {
            const info = categoryDescriptions[selected];
            categoryDescription.innerHTML = `
                <strong>${info.title}</strong><br>
                <small style="color: var(--text-muted);">${info.description}</small>
            `;
            categoryInfo.style.display = 'block';
        } else {
            categoryInfo.style.display = 'none';
        }
    });
    
    // Drag and drop handlers
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });
    
    // File input change handler
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFileSelect(this.files[0]);
        }
    });
    
    // Remove file handler
    document.getElementById('removeFile').addEventListener('click', function() {
        fileInput.value = '';
        filePreview.style.display = 'none';
        uploadZone.style.display = 'block';
        updateSubmitButton();
    });
    
    function handleFileSelect(file) {
        // Validate file size (10MB limit)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be less than 10MB');
            fileInput.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!allowedTypes.includes(fileExtension)) {
            alert('File type not supported. Please upload: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, or PNG files.');
            fileInput.value = '';
            return;
        }
        
        // Update file preview
        const fileName = file.name;
        const fileSize = formatFileSize(file.size);
        const fileIcon = getFileIcon(fileExtension);
        
        document.querySelector('.file-name').textContent = fileName;
        document.querySelector('.file-details').textContent = `${fileSize} • ${fileExtension.toUpperCase()}`;
        document.querySelector('.file-icon i').className = fileIcon;
        
        uploadZone.style.display = 'none';
        filePreview.style.display = 'block';
        
        updateSubmitButton();
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function getFileIcon(extension) {
        const icons = {
            pdf: 'bi bi-file-earmark-pdf-fill',
            doc: 'bi bi-file-earmark-word-fill',
            docx: 'bi bi-file-earmark-word-fill',
            ppt: 'bi bi-file-earmark-ppt-fill',
            pptx: 'bi bi-file-earmark-ppt-fill',
            txt: 'bi bi-file-earmark-text-fill',
            jpg: 'bi bi-file-earmark-image-fill',
            jpeg: 'bi bi-file-earmark-image-fill',
            png: 'bi bi-file-earmark-image-fill'
        };
        return icons[extension] || 'bi bi-file-earmark';
    }
    
    function updateSubmitButton() {
        const hasFile = fileInput.files.length > 0;
        submitBtn.disabled = !hasFile;
        if (!hasFile) {
            submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Select a file to upload';
            submitBtn.classList.add('disabled');
        } else {
            submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Upload Resource';
            submitBtn.classList.remove('disabled');
        }
    }
    
    // Initial state
    updateSubmitButton();
    
    // Form submission handler
    document.getElementById('resourceForm').addEventListener('submit', function() {
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';
        submitBtn.disabled = true;
    });
});
</script>
@endpush
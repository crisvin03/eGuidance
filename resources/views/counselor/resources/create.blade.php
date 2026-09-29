@extends('layouts.dashboard')

@section('title', 'Upload Resource')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; }
    .modern-page-header-compact > a { width: 100%; justify-content: center; margin-top: 1rem; }
    div[style*="display: flex"] { flex-direction: column !important; }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left me-2"></i>Back to Resources
    </a>
</div>

<div class="modern-card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--navy); margin: 0 0 0.5rem 0;">Upload Resource</h1>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;">Upload resources for teachers or students (select category below)</p>
    </div>

    <form action="{{ route('counselor.resources.store') }}" method="POST" enctype="multipart/form-data" id="resourceForm">
        @csrf
        
        <!-- Resource Information -->
        <div style="margin-bottom: 2rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1.25rem;">
                <i class="bi bi-info-circle me-2" style="color: var(--green);"></i>Resource Information
            </h6>
            
            <div style="display: grid; gap: 1.25rem;">
                <div>
                    <label class="modern-form-label">
                        Resource Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control modern-form-control @error('title') is-invalid @enderror" 
                           name="title" value="{{ old('title') }}" required
                           placeholder="Enter a clear, descriptive title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="modern-form-label">
                        Category <span class="text-danger">*</span>
                    </label>
                    <select class="form-control modern-form-control @error('category') is-invalid @enderror" 
                            name="category" required id="categorySelect">
                        <option value="">Select a category</option>
                        <optgroup label="For Teachers">
                            <option value="hrg" {{ old('category') === 'hrg' ? 'selected' : '' }}>Home Room Guidance (HRG)</option>
                            <option value="handbook" {{ old('category') === 'handbook' ? 'selected' : '' }}>Handbook & Policies</option>
                            <option value="gender_dev" {{ old('category') === 'gender_dev' ? 'selected' : '' }}>Gender & Development</option>
                        </optgroup>
                        <optgroup label="For Students">
                            <option value="future_me" {{ old('category') === 'future_me' ? 'selected' : '' }}>Future Me (Career Resources)</option>
                        </optgroup>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Category Info -->
                    <div id="categoryInfo" style="display: none; margin-top: 0.75rem; padding: 0.75rem; background: rgba(30, 122, 74, 0.08); border-left: 3px solid var(--green); border-radius: 0 6px 6px 0;">
                        <div style="font-size: 0.85rem; color: #374151;" id="categoryDescription"></div>
                    </div>
                </div>
                
                <div>
                    <label class="modern-form-label">
                        Description <span style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">(Optional)</span>
                    </label>
                    <textarea class="form-control modern-form-control @error('description') is-invalid @enderror" 
                              name="description" rows="4"
                              placeholder="Provide details about this resource and how teachers can use it...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- File Upload -->
        <div style="margin-bottom: 2rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1.25rem;">
                <i class="bi bi-file-earmark-arrow-up me-2" style="color: var(--green);"></i>Upload File
            </h6>
            
            <div style="border: 2px dashed #d1d5db; border-radius: 12px; padding: 2.5rem 2rem; text-align: center; background: #f9fafb; transition: all 0.2s ease; cursor: pointer; position: relative;" id="uploadZone">
                <input type="file" class="@error('file') is-invalid @enderror" name="file" required id="fileInput" 
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.gif"
                       style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; top: 0; left: 0;">
                
                <div id="uploadPrompt">
                    <i class="bi bi-cloud-upload" style="font-size: 2.5rem; color: var(--green); display: block; margin-bottom: 0.75rem;"></i>
                    <h4 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">
                        Click to upload or drag and drop
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0 0 0.25rem 0;">
                        PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, JPG, PNG • Max 10MB
                    </p>
                </div>
                
                <div id="filePreview" style="display: none;">
                    <div style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.25rem; background: white; border: 1px solid #e5e7eb; border-radius: 8px;">
                        <i class="bi bi-file-earmark-check-fill" style="font-size: 1.75rem; color: var(--green);"></i>
                        <div style="text-align: left;">
                            <div style="font-weight: 600; color: var(--navy); font-size: 0.9rem;" id="fileName"></div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);" id="fileSize"></div>
                        </div>
                        <button type="button" class="modern-btn modern-btn-outline" style="padding: 0.375rem 0.625rem; font-size: 0.8rem; color: #dc2626; border-color: #dc2626; margin-left: 0.5rem;" onclick="clearFile()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
            @error('file')
                <div class="text-danger" style="font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Status -->
        <div style="margin-bottom: 2rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1.25rem;">
                <i class="bi bi-eye me-2" style="color: var(--green);"></i>Visibility
            </h6>
            
            <div style="padding: 1rem; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px;">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="activeSwitch" name="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           style="cursor: pointer; width: 44px; height: 22px;">
                    <label class="form-check-label" for="activeSwitch" style="font-weight: 600; color: var(--navy); cursor: pointer; margin-left: 0.5rem; font-size: 0.95rem;">
                        Make this resource immediately available
                    </label>
                </div>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0.5rem 0 0 3.25rem;">
                    You can change visibility anytime from the management page.
                </p>
            </div>
        </div>
        
        <!-- Actions -->
        <div style="display: flex; gap: 0.75rem; padding-top: 1.5rem; border-top: 2px solid #e5e7eb;">
            <button type="submit" class="modern-btn modern-btn-primary" style="flex: 1; padding: 0.75rem; font-size: 0.95rem; justify-content: center;">
                <i class="bi bi-cloud-upload me-2"></i>Upload Resource
            </button>
            <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="flex: 1; padding: 0.75rem; font-size: 0.95rem; justify-content: center;">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categorySelect');
    const categoryInfo = document.getElementById('categoryInfo');
    const categoryDescription = document.getElementById('categoryDescription');
    const fileInput = document.getElementById('fileInput');
    const uploadZone = document.getElementById('uploadZone');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const filePreview = document.getElementById('filePreview');
    
    // Category descriptions
    const categoryDescriptions = {
        'hrg': '👨‍🏫 FOR TEACHERS: Resources for homeroom guidance lessons, classroom activities, and student development materials.',
        'handbook': '👨‍🏫 FOR TEACHERS: School policies, disciplinary procedures, student handbook materials, and administrative guidelines.',
        'gender_dev': '👨‍🏫 FOR TEACHERS: Gender-sensitive teaching materials, anti-discrimination resources, and inclusive classroom strategies.',
        'future_me': '🎓 FOR STUDENTS: Career guidance resources, college information, scholarship opportunities, and future planning materials.'
    };
    
    categorySelect.addEventListener('change', function() {
        if (this.value && categoryDescriptions[this.value]) {
            categoryDescription.textContent = categoryDescriptions[this.value];
            categoryInfo.style.display = 'block';
        } else {
            categoryInfo.style.display = 'none';
        }
    });
    
    // File upload handling
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            displayFile(this.files[0]);
        }
    });
    
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--green)';
        this.style.background = 'rgba(30, 122, 74, 0.05)';
    });
    
    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
        this.style.background = '#f9fafb';
    });
    
    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
        this.style.background = '#f9fafb';
        
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            displayFile(e.dataTransfer.files[0]);
        }
    });
    
    function displayFile(file) {
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        uploadPrompt.style.display = 'none';
        filePreview.style.display = 'block';
    }
    
    window.clearFile = function() {
        fileInput.value = '';
        uploadPrompt.style.display = 'block';
        filePreview.style.display = 'none';
    };
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
});
</script>
@endsection

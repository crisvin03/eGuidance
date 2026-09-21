@extends('layouts.dashboard')

@section('title', 'Submit Your Creative Work')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-palette-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Submit Your Creative Work</h1>
            <p class="modern-page-subtitle">Share your poetry, artwork, or photography</p>
        </div>
    </div>
</div>

<div style="display: flex; gap: 1.5rem; align-items: start;">
    <!-- Main Form -->
    <div style="flex: 1;">
        <div class="modern-card" style="padding: 1.5rem;">
            @if(session('success'))
            <div class="modern-alert modern-alert-success" style="margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-check-circle-fill" style="font-size: 1.25rem; flex-shrink: 0;"></i>
                    <div>
                        <h6 style="font-weight: 700; margin-bottom: 0.25rem;">Success!</h6>
                        <p style="margin: 0;">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="modern-alert modern-alert-danger" style="margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.25rem; flex-shrink: 0;"></i>
                    <div>
                        <h6 style="font-weight: 700; margin-bottom: 0.5rem;">Please fix the following errors:</h6>
                        <ul style="margin: 0; padding-left: 1.25rem;">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('student.submissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Type Selection -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.75rem; display: block;">
                        <i class="bi bi-palette me-2"></i>Submission Type <span class="text-danger">*</span>
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem;">
                        <div>
                            <input type="radio" class="btn-check" name="type" id="type_poetry" value="poetry" {{ old('type') === 'poetry' ? 'checked' : '' }} required>
                            <label class="btn btn-outline-primary w-100" for="type_poetry" style="padding: 1rem; border-radius: 10px; font-size: 0.875rem; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; border-width: 2px;">
                                <i class="bi bi-feather" style="font-size: 2rem;"></i>
                                <span style="font-weight: 600; font-size: 0.85rem;">Poetry</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check" name="type" id="type_artwork" value="artwork" {{ old('type') === 'artwork' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success w-100" for="type_artwork" style="padding: 1rem; border-radius: 10px; font-size: 0.875rem; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; border-width: 2px;">
                                <i class="bi bi-palette" style="font-size: 2rem;"></i>
                                <span style="font-weight: 600; font-size: 0.85rem;">Artwork</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check" name="type" id="type_photography" value="photography" {{ old('type') === 'photography' ? 'checked' : '' }}>
                            <label class="btn btn-outline-info w-100" for="type_photography" style="padding: 1rem; border-radius: 10px; font-size: 0.875rem; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; border-width: 2px;">
                                <i class="bi bi-camera" style="font-size: 2rem;"></i>
                                <span style="font-weight: 600; font-size: 0.85rem;">Photography</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="title" class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                        <i class="bi bi-chat-dots me-2"></i>Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required style="border-radius: 10px; padding: 0.75rem; font-size: 0.9rem;" placeholder="Give your work a title">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="description" class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                        <i class="bi bi-text-paragraph me-2"></i>Description <span style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted);">(Optional)</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" style="border-radius: 10px; padding: 0.75rem; font-size: 0.9rem;" placeholder="Tell us about your work...">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content for Poetry -->
                <div style="margin-bottom: 1.5rem; display: {{ old('type') === 'poetry' ? 'block' : 'none' }};" id="content_field">
                    <label for="content" class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                        <i class="bi bi-feather me-2"></i>Your Poetry or Story <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" style="border-radius: 10px; padding: 0.875rem; font-size: 0.95rem; font-family: 'Georgia', serif; line-height: 1.8;" placeholder="Write your poem or story here...">{{ old('content') }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-2" style="font-size: 0.8rem;">
                        <i class="bi bi-lightbulb"></i> Tip: Your words matter. Write from the heart.
                    </small>
                </div>

                <!-- File Upload for Artwork/Photography -->
                <div style="margin-bottom: 1.5rem; display: {{ old('type') && old('type') !== 'poetry' ? 'block' : 'none' }};" id="file_field">
                    <label for="file" class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                        <i class="bi bi-paperclip me-2"></i>Upload Your File <span class="text-danger">*</span>
                    </label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept="image/jpeg,image/png,image/gif" style="border-radius: 10px; padding: 0.75rem; font-size: 0.9rem;">
                    @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-2" style="font-size: 0.8rem;">
                        <i class="bi bi-info-circle"></i> Accepted: JPG, PNG, GIF • Max: 5MB
                    </small>
                    
                    <!-- Image Preview -->
                    <div id="image_preview" style="margin-top: 1rem; display: none;">
                        <label style="font-size: 0.8rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem; display: block;">Preview:</label>
                        <img id="preview_img" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 10px; border: 2px solid #e5e7eb;">
                    </div>
                </div>

                <!-- Anonymous Option -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="padding: 1rem; background: rgba(245, 197, 24, 0.08); border-radius: 10px; border-left: 4px solid #d4a800;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_anonymous" style="font-size: 0.875rem; color: var(--navy);">
                                <i class="bi bi-incognito me-2"></i>
                                <strong>Submit Anonymously</strong>
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2" style="font-size: 0.8rem; padding-left: 1.5rem;">Your name will not be displayed if your work is featured</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 0.75rem; padding-top: 1.5rem; border-top: 2px solid #f3f4f6;">
                    <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem;">
                        <i class="bi bi-send me-2"></i>
                        <span>Submit for Review</span>
                    </button>
                    <a href="{{ route('student.resources.index') }}#unfiltered" class="modern-btn modern-btn-secondary" style="padding: 0.75rem 1.5rem; text-decoration: none;">
                        <i class="bi bi-x-circle me-2"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div style="width: 320px;">
        <!-- Guidelines Card -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-lightbulb"></i>
                Guidelines
            </h6>
            <div style="display: flex; flex-direction: column; gap: 0.875rem;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 1rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                    <small style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">Be specific and detailed in your work</small>
                </div>
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 1rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                    <small style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">Choose the appropriate submission type</small>
                </div>
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 1rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                    <small style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">All submissions are reviewed before being featured</small>
                </div>
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-info-circle-fill" style="color: #3b82f6; font-size: 1rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                    <small style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">Express yourself freely and creatively!</small>
                </div>
            </div>
        </div>

        <!-- Review Process Card -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-clock-history"></i>
                Review Process
            </h6>
            <div style="text-align: center; margin-bottom: 1rem;">
                <i class="bi bi-people-fill" style="font-size: 2.5rem; color: var(--green); opacity: 0.8;"></i>
            </div>
            <p style="text-align: center; color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.75rem;">
                <strong style="font-size: 1.5rem; color: var(--navy); display: block; margin-bottom: 0.25rem;">{{ App\Models\User::whereHas('role', fn($q) => $q->where('name', 'counselor'))->where('is_active', 1)->count() }}</strong>
                Counselors available to review
            </p>
            <div style="text-align: center; padding: 0.75rem; background: rgba(30, 122, 74, 0.08); border-radius: 8px;">
                <small style="color: var(--text-muted); font-size: 0.8rem; display: block;">
                    <i class="bi bi-hourglass-split"></i> Average review time
                </small>
                <strong style="color: var(--green); font-size: 0.95rem;">24-48 hours</strong>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const contentField = document.getElementById('content_field');
    const fileField = document.getElementById('file_field');
    const contentInput = document.getElementById('content');
    const fileInput = document.getElementById('file');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');

    // Handle type selection
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'poetry') {
                contentField.style.display = 'block';
                fileField.style.display = 'none';
                contentInput.required = true;
                fileInput.required = false;
                fileInput.value = '';
                imagePreview.style.display = 'none';
            } else {
                contentField.style.display = 'none';
                fileField.style.display = 'block';
                contentInput.required = false;
                fileInput.required = true;
                contentInput.value = '';
            }
        });
    });

    // Handle file preview
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>

<style>
.btn-check:checked + .btn-outline-primary {
    background-color: rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
    color: #3b82f6;
}

.btn-check:checked + .btn-outline-success {
    background-color: rgba(16, 185, 129, 0.1);
    border-color: #10b981;
    color: #10b981;
}

.btn-check:checked + .btn-outline-info {
    background-color: rgba(99, 102, 241, 0.1);
    border-color: #6366f1;
    color: #6366f1;
}
</style>
@endsection

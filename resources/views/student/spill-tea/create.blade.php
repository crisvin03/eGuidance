@extends('layouts.dashboard')

@section('title', 'Spill the Tea')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-chat-heart-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Spill the Tea</h1>
            <p class="modern-page-subtitle">Share what's on your mind. We're here to listen.</p>
        </div>
    </div>
</div>

<div class="modern-grid-2">
    <!-- Main Form Card -->
    <div>
        <div class="modern-card">
            <form method="POST" action="{{ route('student.spill-tea.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Category Selection -->
                <div class="mb-3">
                    <label for="category_id" class="modern-form-label">
                        <i class="bi bi-tag" style="color: var(--green);"></i>
                        <span>What's this about?</span>
                    </label>
                    <select id="category_id" 
                            class="form-select modern-form-control @error('category_id') is-invalid @enderror" 
                            name="category_id" required>
                        <option value="">Choose a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="modern-form-label">
                        <i class="bi bi-pen" style="color: var(--green);"></i>
                        <span>Give it a title</span>
                    </label>
                    <input id="title" type="text" 
                           class="form-control modern-form-control @error('title') is-invalid @enderror" 
                           name="title" value="{{ old('title') }}" required autofocus 
                           placeholder="E.g., I'm feeling overwhelmed with...">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="modern-form-label">
                        <i class="bi bi-chat-left-quote" style="color: var(--green);"></i>
                        <span>Tell us more</span>
                    </label>
                    <textarea id="description" 
                              class="form-control modern-form-control @error('description') is-invalid @enderror" 
                              name="description" rows="6" required 
                              placeholder="Share what's on your mind. Take your time, there's no rush...">{{ old('description') }}</textarea>
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        Your thoughts are safe with us
                    </small>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Attachment -->
                <div class="mb-3">
                    <label class="modern-form-label">
                        <i class="bi bi-paperclip" style="color: var(--green);"></i>
                        <span>Attachment</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <input type="file" id="attachment" name="attachment"
                           class="form-control modern-form-control @error('attachment') is-invalid @enderror"
                           accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        <i class="bi bi-file-earmark me-1"></i>
                        Images, PDFs, or documents • Max 5MB
                    </small>
                    @error('attachment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Anonymous Option -->
                <div class="mb-3">
                    <div style="padding: 0.75rem 1rem; background: rgba(30, 122, 74, 0.06); border-radius: 12px; border-left: 3px solid var(--green);">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="is_anonymous" id="is_anonymous" value="1"
                                   {{ old('is_anonymous') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_anonymous" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                                <i class="bi bi-incognito me-1" style="color: var(--green);"></i>
                                Keep me anonymous
                                <small class="text-muted d-block" style="font-size: 0.75rem; font-weight: 400; line-height: 1.3; margin-top: 0.125rem;">
                                    Your name will be hidden from the concern details
                                </small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 flex-wrap">
                    <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                        <i class="bi bi-send-fill"></i>
                        Share with Care Team
                    </button>
                    <a href="{{ route('student.dashboard') }}" class="modern-btn modern-btn-outline" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                        <i class="bi bi-arrow-left"></i>
                        Maybe Later
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div>
        <!-- Safe Space Card -->
        <div class="modern-card modern-card-compact mb-4">
            <div class="text-center mb-3">
                <div style="width: 56px; height: 56px; margin: 0 auto 1rem; border-radius: 50%; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(30, 122, 74, 0.06)); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--green); box-shadow: 0 4px 12px rgba(30, 122, 74, 0.15);">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
            <h3 class="text-center fw-bold mb-2" style="font-size: 1rem; color: var(--navy);">This is a Safe Space</h3>
            <p class="text-muted text-center mb-0" style="font-size: 0.875rem; line-height: 1.6;">
                Your concerns are treated with care and confidentiality. We're here to listen, support, and help.
            </p>
        </div>

        <!-- What Happens Next -->
        <div class="modern-card modern-card-compact mb-4">
            <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                <div class="modern-section-icon" style="width: 36px; height: 36px; font-size: 1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h3 class="modern-section-title" style="font-size: 1rem;">What happens next?</h3>
            </div>
            
            <div class="d-flex flex-column gap-3">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;background:linear-gradient(135deg, var(--green), #145e38);font-size:.8rem;font-weight:700;color:white;">
                            1
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1" style="color: var(--navy); font-size: 0.9rem;">We receive it</div>
                        <small class="text-muted" style="font-size: 0.8rem;">Instantly delivered to our Care Team</small>
                    </div>
                </div>
                
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;background:linear-gradient(135deg, var(--green), #145e38);font-size:.8rem;font-weight:700;color:white;">
                            2
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1" style="color: var(--navy); font-size: 0.9rem;">Counselor reviews</div>
                        <small class="text-muted" style="font-size: 0.8rem;">Usually within 24-48 hours</small>
                    </div>
                </div>
                
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;background:linear-gradient(135deg, var(--green), #145e38);font-size:.8rem;font-weight:700;color:white;">
                            3
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1" style="color: var(--navy); font-size: 0.9rem;">You get support</div>
                        <small class="text-muted" style="font-size: 0.8rem;">Via message, call, or session</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Counselors Available -->
        <div class="modern-card modern-card-compact text-center">
            <div style="width: 48px; height: 48px; margin: 0 auto 0.75rem; border-radius: 50%; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(30, 122, 74, 0.06)); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--green); box-shadow: 0 4px 12px rgba(30, 122, 74, 0.15);">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="modern-stat-number" style="color: var(--green); font-size: 1.75rem; margin-bottom: 0.5rem;">
                {{ App\Models\User::whereHas('role', fn($q) => $q->where('name', 'counselor'))->where('is_active', 1)->count() }}
            </div>
            <div class="text-muted mb-3" style="font-size: 0.8rem;">Counselors ready to help</div>
            <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                <i class="bi bi-chat-dots"></i>
                Talk to them
            </a>
        </div>
    </div>
</div>
@endsection


<style>
/* Mobile Responsive Adjustments for Spill the Tea */
@media (max-width: 768px) {
    .modern-grid-2 > div:last-child {
        order: -1; /* Move sidebar above form on mobile */
    }
    
    .modern-form-control {
        font-size: 16px !important; /* Prevents iOS zoom */
    }
    
    .modern-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .d-flex.gap-3.flex-wrap {
        flex-direction: column;
        gap: 0.75rem !important;
    }
    
    .modern-btn {
        min-width: auto !important;
        flex: 1 !important;
    }
}
</style>

@extends('layouts.dashboard')

@section('title', 'Teacher Resources')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(4, 120, 87, 0.12)); color: #10b981;">
            <i class="bi bi-book-half"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Teacher Resources</h1>
            <p class="modern-page-subtitle">Access important resources and materials for your teaching practice</p>
        </div>
    </div>
</div>

<!-- Resource Categories -->
<div class="modern-grid-3 mb-4" style="gap: 1.5rem;">
    <!-- Home Room Guidance -->
    <div class="modern-card" style="padding: 1.5rem; text-align: center; border-top: 4px solid var(--green); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
        <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 64px; height: 64px; font-size: 1.75rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-house-heart-fill"></i>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">Home Room Guidance</h3>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.6;">
            Access HRG lesson plans, classroom guidance activities, and student development materials for your homeroom.
        </p>
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem; padding: 0.75rem; background: rgba(30, 122, 74, 0.08); border-radius: 10px;">
            <span style="font-size: 1.75rem; font-weight: 700; color: var(--green);">{{ $hrgCount }}</span>
            <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Available</span>
        </div>
        <a href="{{ route('teacher.resources.hrg') }}" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem; justify-content: center;">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Browse Resources</span>
        </a>
    </div>
    
    <!-- Handbook & Policies -->
    <div class="modern-card" style="padding: 1.5rem; text-align: center; border-top: 4px solid var(--green); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
        <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 64px; height: 64px; font-size: 1.75rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-journal-text"></i>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">Handbook & Policies</h3>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.6;">
            School policies, disciplinary guidelines, student handbook materials, and administrative procedures.
        </p>
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem; padding: 0.75rem; background: rgba(30, 122, 74, 0.08); border-radius: 10px;">
            <span style="font-size: 1.75rem; font-weight: 700; color: var(--green);">{{ $handbookCount }}</span>
            <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Available</span>
        </div>
        <a href="{{ route('teacher.resources.handbook') }}" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem; justify-content: center;">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Browse Resources</span>
        </a>
    </div>
    
    <!-- Gender & Development -->
    <div class="modern-card" style="padding: 1.5rem; text-align: center; border-top: 4px solid var(--green); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
        <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 64px; height: 64px; font-size: 1.75rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-people-fill"></i>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">Gender & Development</h3>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.6;">
            Gender-sensitive teaching materials, anti-discrimination resources, and inclusive classroom strategies.
        </p>
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem; padding: 0.75rem; background: rgba(30, 122, 74, 0.08); border-radius: 10px;">
            <span style="font-size: 1.75rem; font-weight: 700; color: var(--green);">{{ $genderDevCount }}</span>
            <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Available</span>
        </div>
        <a href="{{ route('teacher.resources.gender-dev') }}" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem; justify-content: center;">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Browse Resources</span>
        </a>
    </div>
</div>

<!-- Recent Resources -->
@if($recentResources->count() > 0)
    <div class="modern-card mb-4" style="padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">
                <i class="bi bi-clock-history me-2" style="font-size: 1.1rem; color: #10b981;"></i>
                Recently Added Resources
            </h6>
            <small style="color: var(--text-muted);">Latest uploads from counselors</small>
        </div>
        
        <div class="modern-grid-3" style="gap: 1rem;">
            @foreach($recentResources as $resource)
                <div style="padding: 1.25rem; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; background: rgba(248, 250, 252, 0.5); transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'; this.style.borderColor='var(--green)';" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='rgba(0,0,0,0.08)';">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(30, 122, 74, 0.1); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 1.125rem; flex-shrink: 0;">
                            @if(str_contains(strtolower($resource->category), 'hrg'))
                                <i class="bi bi-house-heart-fill"></i>
                            @elseif(str_contains(strtolower($resource->category), 'handbook'))
                                <i class="bi bi-journal-text"></i>
                            @else
                                <i class="bi bi-people-fill"></i>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3;">
                                {{ Str::limit($resource->title, 45) }}
                            </h6>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                <span class="modern-badge modern-badge-secondary" style="font-size: 0.7rem;">{{ $resource->category_label }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($resource->description)
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.4;">
                            {{ Str::limit($resource->description, 70) }}
                        </p>
                    @endif
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 1rem; border-top: 1px solid rgba(0, 0, 0, 0.06);">
                        <small style="font-size: 0.75rem; color: var(--text-muted);">
                            <i class="bi bi-clock"></i>
                            {{ $resource->created_at->diffForHumans() }}
                        </small>
                        <a href="{{ route('teacher.resources.download', $resource) }}" class="modern-btn modern-btn-secondary" style="padding: 0.375rem 0.875rem; font-size: 0.8rem;">
                            <i class="bi bi-download"></i>
                            <span>Download</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="modern-card mb-4" style="padding: 2rem; text-align: center;">
        <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 0.5rem;"></i>
        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 1rem 0 0.5rem;">No Resources Yet</h6>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;">Resources will appear here once counselors upload them.</p>
    </div>
@endif

<!-- Help Section -->
<div class="modern-alert modern-alert-info">
    <div class="modern-alert-icon">
        <i class="bi bi-question-circle-fill"></i>
    </div>
    <div style="flex: 1;">
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: #10b981;">Need Help?</h6>
        <p style="margin-bottom: 1rem; font-size: 0.9rem; color: var(--text-muted);">
            Can't find what you need? Contact the guidance office to request specific resources or share suggestions for new materials.
        </p>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('teacher.talk-to-counselor') }}" class="modern-btn modern-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="bi bi-chat-dots"></i>
                <span>Contact Counselor</span>
            </a>
            <a href="{{ route('messages.create') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="bi bi-lightbulb"></i>
                <span>Share Ideas</span>
            </a>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .modern-grid-3 {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

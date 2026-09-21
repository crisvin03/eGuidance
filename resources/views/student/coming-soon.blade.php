@extends('layouts.dashboard')

@section('title', 'Coming Soon')

@section('content')
@include('student.partials.modern-styles')

<div style="padding: 2rem 0;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="modern-card" style="padding: 2.5rem; text-align: center;">
                <div style="margin-bottom: 2rem;">
                    <div class="modern-section-icon modern-page-icon-green" style="width: 80px; height: 80px; font-size: 2.5rem; margin: 0 auto;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                
                <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">{{ $feature ?? 'This Feature' }} is Coming Soon!</h3>
                
                <p style="font-size: 1.05rem; color: var(--text-muted); margin-bottom: 2rem; line-height: 1.6;">
                    We're working hard to bring you this awesome feature. Stay tuned! 🚀
                </p>
                
                <div class="modern-alert modern-alert-info" style="margin-bottom: 2rem;">
                    <i class="bi bi-info-circle" style="font-size: 1.5rem; color: #3b82f6;"></i>
                    <div style="flex: 1; text-align: left;">
                        <div style="font-size: 0.95rem; font-weight: 700; color: #3b82f6; margin-bottom: 0.25rem;">Expected Launch</div>
                        <small style="font-size: 0.85rem; color: var(--text-muted);">This feature will be available soon. Check back later!</small>
                    </div>
                </div>
                
                <div style="display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('student.dashboard') }}" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                        <i class="bi bi-house-heart"></i>
                        <span>Back to Tambayan</span>
                    </a>
                    <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-secondary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                        <i class="bi bi-chat-dots"></i>
                        <span>Need Help?</span>
                    </a>
                </div>
            </div>
            
            <!-- Features You Can Use Now -->
            <div class="modern-card" style="padding: 1.5rem; margin-top: 1.5rem;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1.25rem;">
                    <i class="bi bi-stars" style="color: #f5c518; margin-right: 0.5rem;"></i>
                    Features You Can Use Now
                </h6>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <a href="{{ route('student.spill-tea') }}" style="text-decoration: none;">
                        <div class="modern-card hover-card" style="padding: 1.25rem; text-align: center; background: rgba(248, 250, 252, 0.5);">
                            <i class="bi bi-chat-heart-fill" style="font-size: 2.5rem; color: #ec4899; display: block; margin-bottom: 0.75rem;"></i>
                            <small style="font-size: 0.9rem; font-weight: 700; color: var(--navy);">Spill the Tea</small>
                        </div>
                    </a>
                    <a href="{{ route('student.connect') }}" style="text-decoration: none;">
                        <div class="modern-card hover-card" style="padding: 1.25rem; text-align: center; background: rgba(248, 250, 252, 0.5);">
                            <i class="bi bi-people-fill" style="font-size: 2.5rem; color: #a855f7; display: block; margin-bottom: 0.75rem;"></i>
                            <small style="font-size: 0.9rem; font-weight: 700; color: var(--navy);">Connect</small>
                        </div>
                    </a>
                    <a href="{{ route('student.mind-check') }}" style="text-decoration: none;">
                        <div class="modern-card hover-card" style="padding: 1.25rem; text-align: center; background: rgba(248, 250, 252, 0.5);">
                            <i class="bi bi-heart-pulse-fill" style="font-size: 2.5rem; color: #ef4444; display: block; margin-bottom: 0.75rem;"></i>
                            <small style="font-size: 0.9rem; font-weight: 700; color: var(--navy);">Mind Check</small>
                        </div>
                    </a>
                    <a href="{{ route('student.resources.index') }}" style="text-decoration: none;">
                        <div class="modern-card hover-card" style="padding: 1.25rem; text-align: center; background: rgba(248, 250, 252, 0.5);">
                            <i class="bi bi-journal-bookmark-fill" style="font-size: 2.5rem; color: #10b981; display: block; margin-bottom: 0.75rem;"></i>
                            <small style="font-size: 0.9rem; font-weight: 700; color: var(--navy);">Resources</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card { 
    transition: all 0.2s ease; 
}
.hover-card:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 8px 20px rgba(13, 45, 82, 0.15); 
    border-color: #10b981 !important; 
}

@media (max-width: 576px) {
    div[style*="grid-template-columns: repeat(2, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

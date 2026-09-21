@extends('layouts.dashboard')

@section('title', 'Teacher Resources')

@section('content')
@include('student.partials.modern-styles')

<style>
.resource-category-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.resource-category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
}

.resource-category-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.category-hrg::before { background: linear-gradient(90deg, #3b82f6, #1e40af); }
.category-handbook::before { background: linear-gradient(90deg, #10b981, #047857); }
.category-gender-dev::before { background: linear-gradient(90deg, #8b5cf6, #6d28d9); }

.category-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

.category-icon-hrg { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.category-icon-handbook { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.category-icon-gender-dev { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

@media (max-width: 768px) {
    .resource-categories-grid { grid-template-columns: 1fr !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(4, 120, 87, 0.12)); color: #10b981;">
            <i class="bi bi-book-half"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Teacher Resources</h1>
            <p class="modern-page-subtitle">Access important resources and materials for your teaching practice</p>
        </div>
    </div>
</div>

<!-- Resource Categories -->
<div class="resource-categories-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 2rem;">
    <!-- Home Room Guidance -->
    <div class="resource-category-card category-hrg">
        <div class="category-icon category-icon-hrg">
            <i class="bi bi-house-heart-fill"></i>
        </div>
        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--navy); margin-bottom: 1rem;">Home Room Guidance</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem; flex: 1; line-height: 1.6;">
            Access HRG lesson plans, classroom guidance activities, student development materials, and guidance curriculum resources to support your homeroom responsibilities.
        </p>
        <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
            <span style="font-size: 2rem; font-weight: 800; color: #3b82f6;">{{ $hrgCount }}</span>
            <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Resources Available</span>
        </div>
        <a href="{{ route('teacher.resources.hrg') }}" class="modern-btn modern-btn-primary" style="width: 100%; justify-content: center;">
            <i class="bi bi-arrow-right"></i> Browse HRG Resources
        </a>
    </div>
    
    <!-- Handbook & Policies -->
    <div class="resource-category-card category-handbook">
        <div class="category-icon category-icon-handbook">
            <i class="bi bi-shield-check-fill"></i>
        </div>
        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--navy); margin-bottom: 1rem;">Handbook & Policies</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem; flex: 1; line-height: 1.6;">
            Find school policies, disciplinary guidelines, student handbook materials, safety protocols, and administrative procedures that you need to reference in your daily work.
        </p>
        <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
            <span style="font-size: 2rem; font-weight: 800; color: #10b981;">{{ $handbookCount }}</span>
            <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Resources Available</span>
        </div>
        <a href="{{ route('teacher.resources.handbook') }}" class="modern-btn modern-btn-primary" style="width: 100%; justify-content: center;">
            <i class="bi bi-arrow-right"></i> Browse Handbook
        </a>
    </div>
    
    <!-- Gender & Development -->
    <div class="resource-category-card category-gender-dev">
        <div class="category-icon category-icon-gender-dev">
            <i class="bi bi-people-fill"></i>
        </div>
        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--navy); margin-bottom: 1rem;">Gender & Development</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem; flex: 1; line-height: 1.6;">
            Access gender-sensitive teaching materials, anti-discrimination resources, LGBTQ+ awareness guides, and inclusive classroom management strategies for creating a safe learning environment.
        </p>
        <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
            <span style="font-size: 2rem; font-weight: 800; color: #8b5cf6;">{{ $genderDevCount }}</span>
            <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Resources Available</span>
        </div>
        <a href="{{ route('teacher.resources.gender-dev') }}" class="modern-btn modern-btn-primary" style="width: 100%; justify-content: center;">
            <i class="bi bi-arrow-right"></i> Browse Gender Dev
        </a>
    </div>
</div>

<!-- Recent Resources -->
@if($recentResources->count() > 0)
    <div class="modern-card" style="padding: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin: 0;">Recently Added Resources</h3>
                <p style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">Latest materials uploaded by counselors</p>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
            @foreach($recentResources as $resource)
                <div style="background: #f8fafc; border-radius: 12px; padding: 1.5rem; border: 1px solid #e5e7eb; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                        @php
                            $categoryIcons = [
                                'hrg' => ['icon' => 'bi-house-heart-fill', 'color' => '#3b82f6'],
                                'handbook' => ['icon' => 'bi-shield-check-fill', 'color' => '#10b981'], 
                                'gender_dev' => ['icon' => 'bi-people-fill', 'color' => '#8b5cf6']
                            ];
                            $categoryInfo = $categoryIcons[$resource->category];
                        @endphp
                        <div style="width: 40px; height: 40px; background: rgba({{ $categoryInfo['color'] === '#3b82f6' ? '59, 130, 246' : ($categoryInfo['color'] === '#10b981' ? '16, 185, 129' : '139, 92, 246') }}, 0.1); color: {{ $categoryInfo['color'] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.125rem;">
                            <i class="bi {{ $categoryInfo['icon'] }}"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3;">
                                {{ Str::limit($resource->title, 50) }}
                            </h4>
                            <div style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                {{ $resource->category_label }}
                            </div>
                            @if($resource->description)
                                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.4;">
                                    {{ Str::limit($resource->description, 80) }}
                                </p>
                            @endif
                            <div style="display: flex; align-items: center; justify-content: between;">
                                <span style="font-size: 0.75rem; color: var(--text-muted);">
                                    {{ $resource->created_at->diffForHumans() }}
                                </span>
                                <a href="{{ route('teacher.resources.download', $resource) }}" class="modern-btn modern-btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 2rem;">
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('teacher.resources.hrg') }}" class="modern-btn modern-btn-outline">
                    View All HRG Resources
                </a>
                <a href="{{ route('teacher.resources.handbook') }}" class="modern-btn modern-btn-outline">
                    View All Handbook Resources
                </a>
                <a href="{{ route('teacher.resources.gender-dev') }}" class="modern-btn modern-btn-outline">
                    View All Gender Dev Resources
                </a>
            </div>
        </div>
    </div>
@endif

<!-- Help Section -->
<div class="modern-card" style="padding: 2rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.05), rgba(20, 94, 56, 0.05));">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-question-circle-fill"></i>
        </div>
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin: 0;">Need Help?</h3>
            <p style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">Get assistance with resources and materials</p>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        <div>
            <h4 style="font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Can't find what you need?</h4>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 1rem;">Contact the guidance office to request specific resources or materials for your classroom needs.</p>
            <a href="{{ route('teacher.talk-to-counselor') }}" class="modern-btn modern-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="bi bi-chat-dots"></i> Contact Counselor
            </a>
        </div>
        
        <div>
            <h4 style="font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Have suggestions?</h4>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 1rem;">Share ideas for new resources or improvements to existing materials that would help you in your teaching practice.</p>
            <a href="{{ route('messages.create') }}" class="modern-btn modern-btn-outline" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="bi bi-lightbulb"></i> Share Ideas
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth hover animations
    const cards = document.querySelectorAll('.resource-category-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush
@extends('layouts.dashboard')

@section('title', 'Resources')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-book"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Resources & Community</h1>
            <p class="modern-page-subtitle">Mental health resources, articles, and support contacts</p>
        </div>
    </div>
</div>

<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    {{-- Emergency / Panic Attack --}}
    <div class="modern-alert" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
            <div style="font-size: 3rem; flex-shrink: 0;">🆘</div>
            <div style="flex: 1; min-width: 250px;">
                <h5 style="font-size: 1.15rem; font-weight: 700; color: white; margin-bottom: 0.5rem;">
                    Are you having a panic attack or feeling unsafe?
                </h5>
                <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 1rem; font-size: 0.95rem;">
                    You are not alone. Reach out to a professional right now.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                    <a href="tel:0-917-899-8727" class="modern-btn" style="background: white; color: #ef4444; padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600;">
                        <i class="bi bi-telephone-fill"></i>
                        <span>NCMH: 0917-899-8727</span>
                    </a>
                    <a href="tel:1553" class="modern-btn" style="background: white; color: #ef4444; padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600;">
                        <i class="bi bi-telephone-fill"></i>
                        <span>Crisis: 1553</span>
                    </a>
                    <a href="tel:911" class="modern-btn" style="background: white; color: #ef4444; padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600;">
                        <i class="bi bi-telephone-fill"></i>
                        <span>Emergency: 911</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Mental Health Articles --}}
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-book"></i>
            </div>
            <h2 class="modern-section-title" style="font-size: 1.15rem;">Mental Health Reading Materials</h2>
        </div>
        
        <div class="modern-grid-3" style="gap: 1.25rem; margin-top: 1.5rem;">
            @php
            $articles = [
                ['icon'=>'🧠','title'=>'Understanding Anxiety','desc'=>'Learn about anxiety symptoms, causes, and coping strategies from the American Psychological Association.','url'=>'https://www.apa.org/topics/anxiety','badge'=>'APA','color'=>'primary'],
                ['icon'=>'💙','title'=>'Teen Mental Health Guide','desc'=>'A comprehensive guide for teenagers on managing stress, emotions, and mental wellbeing.','url'=>'https://www.nimh.nih.gov/health/topics/child-and-adolescent-mental-health','badge'=>'NIMH','color'=>'info'],
                ['icon'=>'🌱','title'=>'Building Resilience','desc'=>'How to bounce back from adversity, trauma, and stress — practical skills for students.','url'=>'https://www.apa.org/topics/resilience','badge'=>'APA','color'=>'success'],
                ['icon'=>'😴','title'=>'Sleep & Mental Health','desc'=>'The critical connection between sleep and mental health for students and teenagers.','url'=>'https://www.sleepfoundation.org/mental-health','badge'=>'Sleep Foundation','color'=>'warning'],
                ['icon'=>'🤝','title'=>'Dealing with Bullying','desc'=>'Resources and strategies for students dealing with bullying situations at school.','url'=>'https://www.pacer.org/bullying/resources/students/','badge'=>'PACER Center','color'=>'danger'],
                ['icon'=>'📖','title'=>'DepEd Mental Health Policy','desc'=>'The official Department of Education policy on student mental health and wellbeing.','url'=>'https://www.deped.gov.ph/mental-health','badge'=>'DepEd','color'=>'secondary'],
            ];
            @endphp
            @foreach($articles as $a)
            <div class="modern-card" style="padding: 1.5rem; transition: all 0.3s ease;">
                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
                    <span style="font-size: 2rem; line-height: 1; flex-shrink: 0;">{{ $a['icon'] }}</span>
                    <div style="flex: 1;">
                        <span class="modern-badge modern-badge-{{ $a['color'] }}" style="font-size: 0.7rem; margin-bottom: 0.5rem; display: inline-block;">{{ $a['badge'] }}</span>
                        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0;">{{ $a['title'] }}</h6>
                    </div>
                </div>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.25rem; line-height: 1.5;">
                    {{ $a['desc'] }}
                </p>
                <a href="{{ $a['url'] }}" target="_blank" rel="noopener" class="modern-btn modern-btn-secondary" style="width: 100%; padding: 0.625rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Read More</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 2-Column Layout for Tools & Contacts -->
    <div class="modern-grid-2-tools">
    {{-- Self-Help Tools --}}
    <div class="modern-card" style="padding: 1.5rem; height: 100%;">
        <div class="modern-section-header">
            <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-lightbulb"></i>
            </div>
            <h2 class="modern-section-title" style="font-size: 1.15rem;">Self-Help Tools & Exercises</h2>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1.5rem;">
            @php
            $tools = [
                ['icon'=>'bi-wind','title'=>'4-7-8 Breathing Exercise','desc'=>'Calm anxiety instantly with this breathing technique.','url'=>'https://www.healthline.com/health/4-7-8-breathing','color'=>'#10b981'],
                ['icon'=>'bi-journal-text','title'=>'Mood Journal Template','desc'=>'Free printable mood tracking journal for students.','url'=>'https://www.therapistaid.com/therapy-worksheet/mood-journal','color'=>'#6366f1'],
                ['icon'=>'bi-camera-video','title'=>'Guided Meditation (YouTube)','desc'=>'5-minute guided meditation for stress relief.','url'=>'https://www.youtube.com/watch?v=inpok4MKVLM','color'=>'#ef4444'],
                ['icon'=>'bi-phone','title'=>'Calm App (Free)','desc'=>'Meditations, sleep stories, and breathing exercises.','url'=>'https://www.calm.com','color'=>'#3b82f6'],
            ];
            @endphp
            @foreach($tools as $t)
            <a href="{{ $t['url'] }}" target="_blank" rel="noopener" style="text-decoration: none;">
                <div class="modern-list-item" style="padding: 1rem; border-radius: 12px; background: rgba(248, 250, 252, 0.5); transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; gap: 1rem; width: 100%;">
                        <div style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: {{ $t['color'] }}15;">
                            <i class="bi {{ $t['icon'] }}" style="color: {{ $t['color'] }}; font-size: 1.1rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.125rem;">{{ $t['title'] }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $t['desc'] }}</div>
                        </div>
                        <i class="bi bi-arrow-right" style="color: var(--text-muted); font-size: 1.1rem;"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Expert Contacts --}}
    <div class="modern-card" style="padding: 1.5rem; height: 100%;">
        <div class="modern-section-header">
            <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <h2 class="modern-section-title" style="font-size: 1.15rem;">Expert Contacts & Hotlines</h2>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1.5rem;">
            @php
            $contacts = [
                ['icon'=>'bi-heart-pulse','name'=>'NCMH Hope Line','detail'=>'0917-899-8727 / (02) 8989-8727','note'=>'24/7 Crisis & Mental Health Support','color'=>'#ef4444','href'=>'tel:09178998727'],
                ['icon'=>'bi-chat-heart','name'=>'In Touch Crisis Line','detail'=>'(02) 8893-7603','note'=>'Mon–Fri, 9am–5pm','color'=>'#f97316','href'=>'tel:028893-7603'],
                ['icon'=>'bi-globe','name'=>'iCall (Online Counseling)','detail'=>'icallhelpline.org','note'=>'Free online counseling sessions','color'=>'#6366f1','href'=>'https://icallhelpline.org'],
                ['icon'=>'bi-shield-check','name'=>'DepEd Student Protection','detail'=>'(02) 8633-7208','note'=>'Student welfare and protection','color'=>'#10b981','href'=>'tel:028633-7208'],
                ['icon'=>'bi-hospital','name'=>'Emergency Services','detail'=>'911','note'=>'Immediate danger or medical emergency','color'=>'#dc2626','href'=>'tel:911'],
            ];
            @endphp
            @foreach($contacts as $c)
            <a href="{{ $c['href'] }}" target="_blank" rel="noopener" style="text-decoration: none;">
                <div class="modern-list-item" style="padding: 1rem; border-radius: 12px; background: rgba(248, 250, 252, 0.5); transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; gap: 1rem; width: 100%;">
                        <div style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: {{ $c['color'] }}15;">
                            <i class="bi {{ $c['icon'] }}" style="color: {{ $c['color'] }}; font-size: 1.1rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.125rem;">{{ $c['name'] }}</div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: {{ $c['color'] }}; margin-bottom: 0.125rem;">{{ $c['detail'] }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $c['note'] }}</div>
                        </div>
                        <i class="bi bi-arrow-right" style="color: var(--text-muted); font-size: 1.1rem;"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    </div>

</div>

<style>
/* 2-column grid for tools and contacts */
.modern-grid-2-tools {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

/* Hover effects */
.modern-list-item:hover {
    background: rgba(241, 245, 249, 0.8) !important;
    transform: translateX(4px);
}

.modern-grid-3 > .modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13, 45, 82, 0.15);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modern-grid-3 {
        grid-template-columns: 1fr;
    }
    
    .modern-grid-2-tools {
        grid-template-columns: 1fr;
    }
    
    .modern-alert > div {
        flex-direction: column;
        text-align: center;
    }
    
    .modern-alert .modern-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

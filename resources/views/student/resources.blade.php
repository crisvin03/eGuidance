@extends('layouts.dashboard')

@section('title', 'Resources')

@section('content')
<div class="row g-4">

    {{-- Emergency / Panic Attack --}}
    <div class="col-12">
        <div class="card border-0" style="background: linear-gradient(135deg,#ef4444,#b91c1c); color:white;">
            <div class="card-body d-flex align-items-center gap-4 p-4">
                <div style="font-size:3rem; flex-shrink:0;">🆘</div>
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-1">Are you having a panic attack or feeling unsafe?</h5>
                    <p class="mb-3" style="opacity:.9;">You are not alone. Reach out to a professional right now.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="tel:0-917-899-8727" class="btn btn-light btn-sm fw-semibold">
                            <i class="bi bi-telephone-fill me-1 text-danger"></i> NCMH Hopeline: 0917-899-8727
                        </a>
                        <a href="tel:1553" class="btn btn-light btn-sm fw-semibold">
                            <i class="bi bi-telephone-fill me-1 text-danger"></i> Batangas Crisis Line: 1553
                        </a>
                        <a href="tel:911" class="btn btn-light btn-sm fw-semibold">
                            <i class="bi bi-telephone-fill me-1 text-danger"></i> Emergency: 911
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mental Health Articles --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-book me-2 text-primary"></i>Mental Health Reading Materials</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                    $articles = [
                        ['icon'=>'🧠','title'=>'Understanding Anxiety','desc'=>'Learn about anxiety symptoms, causes, and coping strategies from the American Psychological Association.','url'=>'https://www.apa.org/topics/anxiety','badge'=>'APA','color'=>'primary'],
                        ['icon'=>'💙','title'=>'Teen Mental Health Guide','desc'=>'A comprehensive guide for teenagers on managing stress, emotions, and mental wellbeing.','url'=>'https://www.nimh.nih.gov/health/topics/child-and-adolescent-mental-health','badge'=>'NIMH','color'=>'info'],
                        ['icon'=>'🌱','title'=>'Building Resilience','desc'=>'How to bounce back from adversity, trauma, and stress — practical skills for students.','url'=>'https://www.apa.org/topics/resilience','badge'=>'APA','color'=>'success'],
                        ['icon'=>'😴','title'=>'Sleep & Mental Health','desc'=>'The critical connection between sleep and mental health for students and teenagers.','url'=>'https://www.sleepfoundation.org/mental-health','badge'=>'Sleep Foundation','color'=>'warning'],
                        ['icon'=>'🤝','title'=>'Dealing with Bullying','desc'=>'Resources and strategies for students dealing with bullying situations at school.','url'=>'https://www.stopbullying.gov/resources/kids','badge'=>'StopBullying.gov','color'=>'danger'],
                        ['icon'=>'📖','title'=>'DepEd Mental Health Policy','desc'=>'The official Department of Education policy on student mental health and wellbeing.','url'=>'https://www.deped.gov.ph/mental-health','badge'=>'DepEd','color'=>'secondary'],
                    ];
                    @endphp
                    @foreach($articles as $a)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border" style="border-color:#e2e8f0!important;">
                            <div class="card-body">
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <span style="font-size:1.75rem; line-height:1;">{{ $a['icon'] }}</span>
                                    <div>
                                        <span class="badge bg-{{ $a['color'] }} mb-1">{{ $a['badge'] }}</span>
                                        <h6 class="fw-semibold mb-0">{{ $a['title'] }}</h6>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3">{{ $a['desc'] }}</p>
                                <a href="{{ $a['url'] }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Self-Help Tools --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-lightbulb me-2 text-warning"></i>Self-Help Tools & Exercises</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php
                    $tools = [
                        ['icon'=>'bi-wind','title'=>'4-7-8 Breathing Exercise','desc'=>'Calm anxiety instantly with this breathing technique.','url'=>'https://www.healthline.com/health/4-7-8-breathing','color'=>'#20B2AA'],
                        ['icon'=>'bi-journal-text','title'=>'Mood Journal Template','desc'=>'Free printable mood tracking journal for students.','url'=>'https://www.therapistaid.com/therapy-worksheet/mood-journal','color'=>'#6366f1'],
                        ['icon'=>'bi-camera-video','title'=>'Guided Meditation (YouTube)','desc'=>'5-minute guided meditation for stress relief.','url'=>'https://www.youtube.com/watch?v=inpok4MKVLM','color'=>'#ef4444'],
                        ['icon'=>'bi-phone','title'=>'Calm App (Free)','desc'=>'Meditations, sleep stories, and breathing exercises.','url'=>'https://www.calm.com','color'=>'#0ea5e9'],
                    ];
                    @endphp
                    @foreach($tools as $t)
                    <a href="{{ $t['url'] }}" target="_blank" rel="noopener" class="text-decoration-none">
                        <div class="d-flex align-items-center gap-3 p-3 rounded" style="background:#f8fafc; transition:background .2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:{{ $t['color'] }}20;">
                                <i class="bi {{ $t['icon'] }}" style="color:{{ $t['color'] }};font-size:1.1rem;"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark" style="font-size:.9rem;">{{ $t['title'] }}</div>
                                <div class="text-muted" style="font-size:.8rem;">{{ $t['desc'] }}</div>
                            </div>
                            <i class="bi bi-arrow-right ms-auto text-muted"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Expert Contacts --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-2 text-success"></i>Expert Contacts & Hotlines</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php
                    $contacts = [
                        ['icon'=>'bi-heart-pulse','name'=>'NCMH Hope Line','detail'=>'0917-899-8727 / (02) 8989-8727','note'=>'24/7 Crisis & Mental Health Support','color'=>'#ef4444','href'=>'tel:09178998727'],
                        ['icon'=>'bi-chat-heart','name'=>'In Touch Crisis Line','detail'=>'(02) 8893-7603','note'=>'Mon–Fri, 9am–5pm','color'=>'#f97316','href'=>'tel:028893-7603'],
                        ['icon'=>'bi-globe','name'=>'iCall (Online Counseling)','detail'=>'icallhelpline.org','note'=>'Free online counseling sessions','color'=>'#6366f1','href'=>'https://icallhelpline.org'],
                        ['icon'=>'bi-shield-check','name'=>'DepEd Student Protection','detail'=>'(02) 8633-7208','note'=>'Student welfare and protection','color'=>'#20B2AA','href'=>'tel:028633-7208'],
                        ['icon'=>'bi-hospital','name'=>'Emergency Services','detail'=>'911','note'=>'Immediate danger or medical emergency','color'=>'#b91c1c','href'=>'tel:911'],
                    ];
                    @endphp
                    @foreach($contacts as $c)
                    <a href="{{ $c['href'] }}" target="_blank" rel="noopener" class="text-decoration-none">
                        <div class="d-flex align-items-center gap-3 p-3 rounded" style="background:#f8fafc; transition:background .2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:{{ $c['color'] }}20;">
                                <i class="bi {{ $c['icon'] }}" style="color:{{ $c['color'] }};font-size:1.1rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark" style="font-size:.9rem;">{{ $c['name'] }}</div>
                                <div class="fw-bold" style="font-size:.85rem;color:{{ $c['color'] }};">{{ $c['detail'] }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $c['note'] }}</div>
                            </div>
                            <i class="bi bi-arrow-right ms-auto text-muted"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

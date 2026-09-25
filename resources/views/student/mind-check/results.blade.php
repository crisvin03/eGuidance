@extends('layouts.dashboard')

@section('title', 'Assessment Results')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon">
            <i class="bi bi-clipboard-data-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title">Your Assessment Results</h1>
            <p class="modern-page-subtitle">{{ $assessment->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-primary">
            <i class="bi bi-arrow-left"></i>
            <span>View All</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Assessment Type Badge -->
        <div class="mb-4">
            @if($assessment->assessment_type === 'headss')
                <span class="modern-badge modern-badge-primary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    <i class="bi bi-person-heart"></i> HEADSS Psychosocial Assessment
                </span>
            @elseif($assessment->assessment_type === 'gad7')
                <span class="modern-badge modern-badge-primary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    <i class="bi bi-activity"></i> GAD-7 Anxiety Screening
                </span>
            @elseif($assessment->assessment_type === 'phq9')
                <span class="modern-badge modern-badge-primary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    <i class="bi bi-heart-pulse"></i> PHQ-9 Depression Screening
                </span>
            @endif
        </div>

        @if($assessment->assessment_type === 'headss')
            <!-- HEADSS Results -->
            <div class="modern-card mb-4">
                <h5 class="fw-bold mb-4" style="color: #111827;">Your Responses</h5>
                
                @php
                    $domains = [
                        'home' => ['icon' => 'house-heart-fill', 'title' => 'Home Environment'],
                        'education' => ['icon' => 'book-fill', 'title' => 'Education'],
                        'activities' => ['icon' => 'people-fill', 'title' => 'Activities & Peers'],
                        'drugs' => ['icon' => 'shield-x', 'title' => 'Substance Use'],
                        'sexuality' => ['icon' => 'heart', 'title' => 'Sexuality & Relationships'],
                        'suicide' => ['icon' => 'heart-pulse-fill', 'title' => 'Mood & Mental Health']
                    ];
                @endphp

                @foreach($domains as $key => $domain)
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-{{ $domain['icon'] }}" style="color:var(--green); font-size: 1.1rem;"></i>
                            <h6 class="fw-semibold mb-0" style="color: #111827;">{{ $domain['title'] }}</h6>
                        </div>
                        @foreach($assessment->responses as $qKey => $response)
                            @if(str_starts_with($qKey, $key))
                                <div class="mb-3 p-3" style="background:rgba(30, 122, 74, 0.04);border-radius:12px;border-left: 3px solid var(--green);">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 600;">{{ ucwords(str_replace('_', ' ', str_replace($key.'_', '', $qKey))) }}</small>
                                    <div style="color: #374151;">{{ $response }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>

        @else
            <!-- GAD-7 / PHQ-9 Score Display -->
            <div class="modern-card mb-4">
                <div class="text-center" style="padding: 2rem 1rem;">
                    <h5 class="fw-bold mb-4" style="color: #111827;">Your Score</h5>
                    <div class="display-1 fw-bold mb-2" style="color: var(--green);">
                        {{ $assessment->score }}
                    </div>
                    <p class="text-muted mb-4">out of {{ $assessment->assessment_type === 'gad7' ? '21' : '27' }}</p>
                    
                    <span class="modern-badge {{ 
                        $assessment->risk_level === 'low' ? 'modern-badge-success' :
                        ($assessment->risk_level === 'mild' ? 'modern-badge-warning' :
                        'modern-badge-danger') }}" style="font-size: 1rem; padding: 0.5rem 1.5rem;">
                        {{ ucwords(str_replace('-', ' ', $assessment->risk_level)) }} 
                        @if($assessment->assessment_type === 'gad7')
                            Anxiety
                        @else
                            Depression
                        @endif
                    </span>
                </div>
            </div>

            <!-- Detailed Responses -->
            <div class="modern-card mb-4">
                <h5 class="fw-bold mb-4" style="color: #111827;">Your Responses</h5>
                
                @php
                    $options = ['Not at all', 'Several days', 'More than half the days', 'Nearly every day'];
                    $questions = $assessment->assessment_type === 'gad7' ? [
                        'Feeling nervous, anxious, or on edge',
                        'Not being able to stop or control worrying',
                        'Worrying too much about different things',
                        'Trouble relaxing',
                        'Being so restless that it\'s hard to sit still',
                        'Becoming easily annoyed or irritable',
                        'Feeling afraid as if something awful might happen'
                    ] : [
                        'Little interest or pleasure in doing things',
                        'Feeling down, depressed, or hopeless',
                        'Trouble falling or staying asleep, or sleeping too much',
                        'Feeling tired or having little energy',
                        'Poor appetite or overeating',
                        'Feeling bad about yourself',
                        'Trouble concentrating on things',
                        'Moving or speaking slowly, or being restless',
                        'Thoughts of self-harm'
                    ];
                @endphp

                @foreach($questions as $index => $question)
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3" style="border-bottom: 1px solid #e5e7eb;">
                        <div class="flex-grow-1">
                            <div class="fw-semibold mb-1" style="color: #111827;">{{ $index + 1 }}. {{ $question }}</div>
                            <small class="text-muted">{{ $options[$assessment->responses['q'.($index+1)]] ?? 'Not answered' }}</small>
                        </div>
                        <span class="modern-badge modern-badge-primary">
                            {{ $assessment->responses['q'.($index+1)] }} pts
                        </span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Recommendations -->
        <div class="modern-card mb-4">
            <h5 class="fw-bold mb-3" style="color: #111827;">Recommendations</h5>
            
            @if($assessment->risk_level === 'low')
                <div class="alert mb-3" style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(20, 94, 56, 0.08)); border: none; border-radius: 12px; border-left: 4px solid var(--green);">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-check-circle-fill fs-4" style="color:var(--green);"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="color:var(--green);">You're doing well!</h6>
                            <small class="text-muted">Your responses suggest minimal concerns at this time. Continue with self-care practices and reach out if things change.</small>
                        </div>
                    </div>
                </div>
                <ul class="mb-0" style="color: #374151;">
                    <li class="mb-2">Maintain healthy routines (sleep, exercise, nutrition)</li>
                    <li class="mb-2">Stay connected with supportive friends and family</li>
                    <li class="mb-2">Continue activities you enjoy</li>
                    <li>Remember we're here if you need support in the future</li>
                </ul>
                
            @elseif($assessment->risk_level === 'mild')
                <div class="alert mb-3" style="background: rgba(245,158,11,0.08); border: none; border-radius: 12px; border-left: 4px solid #f59e0b;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-info-circle-fill fs-4" style="color:#f59e0b;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="color:#f59e0b;">Consider talking to someone</h6>
                            <small class="text-muted">Your responses suggest mild symptoms. It may be helpful to talk with a counselor about what you're experiencing.</small>
                        </div>
                    </div>
                </div>
                <ul class="mb-0" style="color: #374151;">
                    <li class="mb-2">Consider scheduling a check-in with a CARE Team counselor</li>
                    <li class="mb-2">Practice stress management techniques</li>
                    <li class="mb-2">Monitor your symptoms - track if they get better or worse</li>
                    <li>Reach out to trusted friends or family for support</li>
                </ul>
                
            @else
                <div class="alert mb-3" style="background: rgba(239,68,68,0.08); border: none; border-radius: 12px; border-left: 4px solid #ef4444;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4" style="color:#ef4444;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="color:#ef4444;">We recommend connecting with a counselor</h6>
                            <small class="text-muted">Your responses suggest {{ $assessment->risk_level === 'moderate' ? 'moderate' : 'significant' }} symptoms. Speaking with a counselor can help you develop strategies and get appropriate support.</small>
                        </div>
                    </div>
                </div>
                <ul class="mb-3" style="color: #374151;">
                    <li class="mb-2"><strong>Schedule an appointment with a CARE Team counselor soon</strong></li>
                    <li class="mb-2">Reach out to trusted adults (parents, teachers, mentors)</li>
                    <li class="mb-2">Call crisis support if you're in distress: <strong>1553</strong> or <strong>0917-899-USAP (8727)</strong></li>
                    <li>Know that support is available and you don't have to face this alone</li>
                </ul>
            @endif
        </div>

        <!-- Actions -->
        <div class="d-grid gap-2">
            <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-primary" style="justify-content: center;">
                <i class="bi bi-calendar-plus"></i>
                <span>Book an Appointment</span>
            </a>
            <a href="{{ route('student.spill-tea') }}" class="modern-btn modern-btn-secondary" style="justify-content: center;">
                <i class="bi bi-chat-dots"></i>
                <span>Share a Concern</span>
            </a>
            <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-secondary" style="justify-content: center;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Mind Check</span>
            </a>
            <button type="button" class="modern-btn modern-btn-secondary" style="justify-content: center; border-color: #ef4444; color: #ef4444;" onclick="confirmDelete()">
                <i class="bi bi-trash"></i>
                <span>Delete Assessment</span>
            </button>
        </div>

        <!-- Delete Form (Hidden) -->
        <form id="deleteForm" method="POST" action="{{ route('student.mind-check.delete', $assessment) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Assessment Info -->
        <div class="modern-card mb-3">
            <h6 class="fw-bold mb-3" style="color: #111827;">Assessment Details</h6>
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid #e5e7eb;">
                <small class="text-muted">Type</small>
                <small class="fw-semibold">{{ strtoupper($assessment->assessment_type) }}</small>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid #e5e7eb;">
                <small class="text-muted">Date</small>
                <small class="fw-semibold">{{ $assessment->created_at->format('M j, Y') }}</small>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid #e5e7eb;">
                <small class="text-muted">Time</small>
                <small class="fw-semibold">{{ $assessment->created_at->format('g:i A') }}</small>
            </div>
            @if($assessment->assessment_type !== 'headss')
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid #e5e7eb;">
                    <small class="text-muted">Score</small>
                    <small class="fw-semibold">{{ $assessment->score }}/{{ $assessment->assessment_type === 'gad7' ? '21' : '27' }}</small>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Risk Level</small>
                <small class="fw-semibold">{{ ucwords(str_replace('-', ' ', $assessment->risk_level)) }}</small>
            </div>
        </div>

        <!-- Confidentiality -->
        <div class="modern-card mb-3" style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(20, 94, 56, 0.08));">
            <div class="text-center">
                <div class="modern-section-icon mx-auto mb-2">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6 class="fw-bold mb-2" style="color: #111827;">Your Results Are Private</h6>
                <p class="text-muted small mb-0">
                    Only you and CARE Team counselors can see your assessment results.
                </p>
            </div>
        </div>

        <!-- Need Help Now -->
        <div class="modern-card" style="background: rgba(239,68,68,0.08);">
            <h6 class="fw-bold mb-3" style="color: #111827;">Need Help Right Now?</h6>
            <p class="small text-muted mb-3">If you're in crisis or need immediate support:</p>
            <div class="mb-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-telephone-fill" style="color:#ef4444;"></i>
                    <strong style="color: #111827;">National Crisis Hotline</strong>
                </div>
                <div class="ms-4">
                    <small style="color: #374151;">📞 <strong>1553</strong></small><br>
                    <small style="color: #374151;">📱 <strong>0917-899-USAP (8727)</strong></small>
                </div>
            </div>
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-chat-dots-fill" style="color:#ef4444;"></i>
                    <strong style="color: #111827;">Talk to CARE Team</strong>
                </div>
                <div class="ms-4">
                    <small style="color: #374151;">Visit the Guidance Office or message a counselor</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this assessment? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection

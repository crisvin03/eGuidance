@extends('layouts.dashboard')

@section('title', 'Assessment Details')

@section('content')
@include('student.partials.modern-styles')

<style>
/* Mobile Responsive Styles for Counselor Pages */
@media (max-width: 768px) {
    /* Two-column grid becomes single column */
    div[style*="grid-template-columns: 1fr 380px"] {
        display: block !important;
    }
    
    /* Remove fixed widths on mobile */
    .modern-card {
        margin-bottom: 1rem !important;
    }
    
    /* Stack action buttons vertically */
    div[style*="display: flex"][style*="gap"] {
        flex-direction: column !important;
    }
    
    /* Full width buttons on mobile */
    .modern-btn {
        width: 100% !important;
        justify-content: center !important;
    }
    
    /* Reduce padding on cards */
    .modern-card[style*="padding: 1.5rem"] {
        padding: 1rem !important;
    }
    
    /* Make badges smaller */
    .modern-badge, .badge {
        font-size: 0.75rem !important;
    }
    
    /* Responsive grid for info boxes */
    .row.g-3 {
        gap: 0.5rem !important;
    }
    
    /* Full width columns on mobile */
    .col-md-6, .col-md-4, .col-md-3 {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Smaller text on mobile */
    h1[style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }
    
    h6.fw-bold {
        font-size: 0.95rem !important;
    }
    
    /* Response cards more compact */
    div[style*="border-left: 3px solid #1e7a4a"] {
        padding: 0.75rem !important;
    }
    
    /* Smaller circular badges */
    .rounded-circle[style*="width: 32px"] {
        width: 28px !important;
        height: 28px !important;
        min-width: 28px !important;
        font-size: 0.75rem !important;
    }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('counselor.mental-health.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i> Back to Assessments
    </a>
</div>

<!-- Page Header -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--green); margin: 0 0 0.5rem 0;">Mental Health Assessment</h1>
            <p style="color: var(--text-muted); margin: 0;">{{ $assessment->assessment_name }} - {{ $assessment->created_at->format('M d, Y') }}</p>
        </div>
        <span class="badge bg-{{ $assessment->risk_level_color }} fs-6">
            {{ $assessment->risk_level_text }}
        </span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <!-- Student Info -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-person-circle me-2" style="color:#1e7a4a;"></i>Student Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Name</small>
                        <strong>{{ $assessment->user->name }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Email</small>
                        <strong>{{ $assessment->user->email }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Assessment Type</small>
                        <span class="badge bg-primary">{{ $assessment->assessment_name }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Date Taken</small>
                        <strong>{{ $assessment->created_at->format('F d, Y h:i A') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Results -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="text-center p-3 rounded" style="background:linear-gradient(135deg,rgba(30,122,74,0.1),rgba(20,94,56,0.05));">
                        <h2 class="fw-bold mb-1" style="color:#1e7a4a;">{{ $assessment->score ?? 'N/A' }}</h2>
                        <p class="mb-0 text-muted small">Total Score</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center p-3 rounded" style="background:linear-gradient(135deg,rgba(239,68,68,0.1),rgba(239,68,68,0.05));">
                        <h5 class="fw-bold mb-1">
                            <span class="badge bg-{{ $assessment->risk_level_color }}">
                                {{ $assessment->risk_level_text }}
                            </span>
                        </h5>
                        <p class="mb-0 text-muted small">Risk Level</p>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 0.5rem;">
                <h6 class="fw-semibold mb-3" style="color: var(--navy);"><i class="bi bi-chat-square-text me-2"></i>Response Details</h6>
                @if($assessment->responses && count($assessment->responses) > 0)
                    @php
                        // Define question mappings
                        $questionMaps = [
                            'gad7' => [
                                'q1' => 'Feeling nervous, anxious, or on edge',
                                'q2' => 'Not being able to stop or control worrying',
                                'q3' => 'Worrying too much about different things',
                                'q4' => 'Trouble relaxing',
                                'q5' => 'Being so restless that it\'s hard to sit still',
                                'q6' => 'Becoming easily annoyed or irritable',
                                'q7' => 'Feeling afraid as if something awful might happen',
                            ],
                            'phq9' => [
                                'q1' => 'Little interest or pleasure in doing things',
                                'q2' => 'Feeling down, depressed, or hopeless',
                                'q3' => 'Trouble falling or staying asleep, or sleeping too much',
                                'q4' => 'Feeling tired or having little energy',
                                'q5' => 'Poor appetite or overeating',
                                'q6' => 'Feeling bad about yourself or that you are a failure',
                                'q7' => 'Trouble concentrating on things',
                                'q8' => 'Moving or speaking slowly, or being fidgety or restless',
                                'q9' => 'Thoughts that you would be better off dead or hurting yourself',
                            ],
                            'headss' => []
                        ];
                        
                        $answerLabels = [
                            '0' => 'Not at all',
                            '1' => 'Several days',
                            '2' => 'More than half the days',
                            '3' => 'Nearly every day',
                        ];
                        
                        $currentQuestions = $questionMaps[$assessment->assessment_type] ?? [];
                    @endphp
                    <div class="row g-2">
                        @foreach($assessment->responses as $key => $response)
                        <div class="col-12">
                            <div class="p-3 rounded d-flex align-items-start gap-3" style="background: #f8fafc; border-left: 3px solid #1e7a4a;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; min-width: 32px; background: linear-gradient(135deg, #1e7a4a, #145e38); color: white; font-weight: 600; font-size: 0.8rem;">
                                    {{ is_numeric(str_replace('q', '', $key)) ? str_replace('q', '', $key) : substr($key, 0, 1) }}
                                </div>
                                <div style="flex: 1;">
                                    <div class="small fw-semibold mb-1" style="color: #1e293b;">
                                        {{ $currentQuestions[$key] ?? (is_numeric($key) ? 'Question ' . ($key + 1) : ucfirst(str_replace('_', ' ', $key))) }}
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        @if(is_array($response))
                                            @foreach($response as $rKey => $rVal)
                                                <span class="small"><strong>{{ ucfirst(str_replace('_', ' ', $rKey)) }}:</strong> {{ $rVal }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge" style="background: #e0f2e9; color: #1e7a4a; font-size: 0.85rem; padding: 0.35rem 0.75rem;">{{ $answerLabels[$response] ?? $response }}</span>
                                            @if(is_numeric($response))
                                            <span class="badge" style="background: #1e7a4a; color: white; font-size: 0.8rem; padding: 0.35rem 0.65rem; font-weight: 700;">{{ $response }} {{ $response == 1 ? 'pt' : 'pts' }}</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3" style="color: #94a3b8;">
                        <i class="bi bi-clipboard-x fs-2 d-block mb-2"></i>
                        <small>No response data available</small>
                    </div>
                @endif
            </div>
        </div>

        @if($assessment->counselor_notes)
        <!-- Counselor Notes -->
        <div class="alert alert-info mb-4">
            <h6 class="alert-heading fw-semibold"><i class="bi bi-journal-medical me-1"></i>Counselor Notes</h6>
            <p class="mb-0" style="white-space:pre-wrap;">{{ $assessment->counselor_notes }}</p>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Follow-up Management -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-calendar-check me-2" style="color:#1e7a4a;"></i>Follow-up Management
            </h6>
            <div>
                <form method="POST" action="{{ route('counselor.mental-health.update', $assessment) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Follow-up Status</label>
                        <select class="form-select" name="follow_up_scheduled" id="followUpScheduled" onchange="toggleDateField()">
                            <option value="0" {{ !$assessment->follow_up_scheduled ? 'selected' : '' }}>Not Scheduled</option>
                            <option value="1" {{ $assessment->follow_up_scheduled ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>

                    <div class="mb-3" id="dateField" style="display:{{ $assessment->follow_up_scheduled ? 'block' : 'none' }};">
                        <label class="form-label fw-semibold">Follow-up Date</label>
                        <input type="date" class="form-control" name="follow_up_date" 
                               value="{{ $assessment->follow_up_date?->format('Y-m-d') }}"
                               min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Counselor Notes</label>
                        <textarea class="form-control" name="counselor_notes" rows="6" 
                                  placeholder="Add your observations, recommendations, or action plans...">{{ old('counselor_notes', $assessment->counselor_notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-1"></i>Update Assessment
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-lightning-charge me-2" style="color:#1e7a4a;"></i>Quick Actions
            </h6>
            <div>
                <a href="{{ route('messages.create', ['user_id' => $assessment->user_id]) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                    <i class="bi bi-chat-dots me-1"></i>Message Student
                </a>
                <a href="{{ route('counselor.concerns.index', ['student_id' => $assessment->user_id]) }}" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                    <i class="bi bi-file-text me-1"></i>View Student Concerns
                </a>
                <a href="{{ route('counselor.appointments.index', ['student_id' => $assessment->user_id]) }}" class="btn btn-outline-info btn-sm w-100 mb-2">
                    <i class="bi bi-calendar3 me-1"></i>Schedule Appointment
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="confirmDelete()">
                    <i class="bi bi-trash me-1"></i>Delete Assessment
                </button>
            </div>
        </div>

        <!-- Delete Form (Hidden) -->
        <form id="deleteForm" method="POST" action="{{ route('counselor.mental-health.delete', $assessment) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <!-- Risk Level Guide -->
        @if(in_array($assessment->risk_level, ['high', 'moderately-high']))
        <div class="alert alert-danger" style="border-radius:12px;">
            <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>High Risk Alert</h6>
            <p class="mb-0 small">This student requires immediate attention. Consider scheduling a follow-up session or reaching out directly.</p>
        </div>
        @endif
    </div>
</div>

<script>
function toggleDateField() {
    const scheduled = document.getElementById('followUpScheduled').value;
    const dateField = document.getElementById('dateField');
    dateField.style.display = scheduled === '1' ? 'block' : 'none';
}

function confirmDelete() {
    if (confirm('Are you sure you want to delete this assessment? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection

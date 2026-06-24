@extends('layouts.dashboard')
@section('title', 'Forms & Downloads')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Forms & Downloads</h5>
    <small class="text-muted">Access and download all available forms submitted by teachers</small>
</div>

<div class="row g-4">
    @php
        $forms = [
            ['icon' => 'bi-phone', 'title' => 'Confiscation Slip (Electronic Device)', 'desc' => 'For confiscation of portable electronic devices per school policy.', 'id' => 'confiscation-electronic'],
            ['icon' => 'bi-envelope-paper', 'title' => 'Call Slip', 'desc' => 'For summoning parents/guardians to the Guidance Office.', 'id' => 'call-slip'],
            ['icon' => 'bi-shield-exclamation', 'title' => 'Initial Risk Assessment Form', 'desc' => 'For initial risk assessment of students with safety concerns.', 'id' => 'risk-assessment'],
            ['icon' => 'bi-slash-circle', 'title' => 'Confiscation Slip (Prohibited Items)', 'desc' => 'For confiscation of prohibited or dangerous items from students.', 'id' => 'confiscation-prohibited'],
            ['icon' => 'bi-backpack', 'title' => 'Random Routine Bag Search Plan', 'desc' => 'For documenting routine bag search activities per school year.', 'id' => 'bag-search'],
            ['icon' => 'bi-award', 'title' => 'Good Moral Request Form', 'desc' => 'For requesting good moral character certification for students.', 'id' => 'good-moral'],
            ['icon' => 'bi-house-heart', 'title' => 'Home Visitation Form', 'desc' => 'For documenting home visitation activities and observations.', 'id' => 'home-visitation'],
            ['icon' => 'bi-journal-text', 'title' => 'Session Notes Template', 'desc' => 'Template for documenting counseling session notes.', 'id' => 'session-notes'],
            ['icon' => 'bi-clipboard-data', 'title' => 'Case Summary Report', 'desc' => 'Template for comprehensive case summary and documentation.', 'id' => 'case-summary'],
        ];
    @endphp

    @foreach($forms as $form)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;min-width:45px;background:rgba(32,178,170,0.1);">
                        <i class="bi {{ $form['icon'] }} fs-5" style="color:#20B2AA;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $form['title'] }}</h6>
                        <p class="text-muted small mb-0">{{ $form['desc'] }}</p>
                    </div>
                </div>
                <div class="mt-auto pt-3 border-top">
                    <button class="btn btn-sm text-white w-100 fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"
                            onclick="window.open('{{ route('teacher.forms.index') }}', '_blank')">
                        <i class="bi bi-download me-1"></i> Access Form
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mt-4 border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2" style="color:#20B2AA;"></i>About Forms & Downloads</h6>
        <p class="text-muted mb-2">This section provides access to all standard forms used in the guidance program. These forms are the same ones teachers use when submitting reports and referrals.</p>
        <p class="text-muted mb-0"><strong>Note:</strong> All forms can be filled out, printed, and stored in student records as needed. For digital submissions, refer to the respective sections (Incident Reports, Referrals, etc.).</p>
    </div>
</div>
@endsection

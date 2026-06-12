@extends('layouts.dashboard')
@section('title', 'Generate Forms')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Generate Forms</h5>
    <small class="text-muted">Download standardized CARE Center forms. System auto-fills student, teacher, and date information where applicable.</small>
</div>

<div class="row g-4">
    @php
        $forms = [
            ['icon' => '📋', 'title' => 'Incident Report Form', 'desc' => 'For reporting learner incidents and behavioral concerns to the CARE Center.', 'id' => 'incident-report', 'ready' => false],
            ['icon' => '🏠', 'title' => 'Home Visitation Form', 'desc' => 'For documenting home visitation activities and parent/guardian interactions.', 'id' => 'home-visitation', 'ready' => false],
            ['icon' => '🏅', 'title' => 'Good Moral Certificate Request', 'desc' => 'For requesting a good moral character certification for students.', 'id' => 'good-moral', 'ready' => false],
            ['icon' => '📩', 'title' => 'Call Slip', 'desc' => 'For summoning a student to the CARE Center for counseling or conference.', 'id' => 'call-slip', 'ready' => false],
            ['icon' => '📱', 'title' => 'Confiscation Slip (Electronic Device)', 'desc' => 'For confiscation of portable electronic devices per school policy.', 'id' => 'confiscation-electronic', 'ready' => false],
            ['icon' => '🚫', 'title' => 'Confiscation Slip (Prohibited Items)', 'desc' => 'For confiscation of prohibited or dangerous items from students.', 'id' => 'confiscation-prohibited', 'ready' => false],
            ['icon' => '🎒', 'title' => 'Random Routine Bag Search Plan', 'desc' => 'For documenting and planning routine bag search activities.', 'id' => 'bag-search', 'ready' => false],
            ['icon' => '⚠️', 'title' => 'Initial Risk Assessment Form', 'desc' => 'For initial risk assessment of students with safety or mental health concerns.', 'id' => 'risk-assessment', 'ready' => false],
        ];
    @endphp

    @foreach($forms as $form)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="fs-2">{{ $form['icon'] }}</div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $form['title'] }}</h6>
                        <p class="text-muted small mb-0">{{ $form['desc'] }}</p>
                    </div>
                </div>
                <div class="mt-auto pt-3 border-top">
                    @if($form['ready'])
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                            <button class="btn btn-sm text-white flex-fill" style="background:#20B2AA;">
                                <i class="bi bi-download me-1"></i>PDF
                            </button>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark">Form template coming soon</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="alert alert-info mt-4 border-0" style="border-radius:12px;background:rgba(32,178,170,0.08);border-left:4px solid #20B2AA !important;">
    <i class="bi bi-info-circle me-2" style="color:#20B2AA;"></i>
    <strong>Note:</strong> Form templates will be uploaded by the administrator. Once available, forms will auto-fill with student information, teacher details, and current date. You will be able to download or print them directly.
</div>
@endsection

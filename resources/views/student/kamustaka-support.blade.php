@extends('layouts.dashboard')
@section('title', 'We\'re Here For You')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Header Banner -->
        <div class="card border-0 mb-4" style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:20px;">
            <div class="card-body p-5 text-white text-center">
                <div class="fs-1 mb-3">💙</div>
                <h3 class="fw-bold mb-2">We're Here For You</h3>
                <p class="mb-0 opacity-90">Thank you for being honest. You are not alone — please reach out for support.</p>
            </div>
        </div>

        <!-- Emergency Support Contacts -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;border-left:5px solid #ef4444 !important;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-telephone-fill text-danger me-2"></i>Emergency Support Contacts
                </h6>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:#fef2f2;">
                            <div class="fw-semibold small text-danger mb-1"><i class="bi bi-shield-fill-exclamation me-1"></i>National Crisis Line</div>
                            <div class="fs-5 fw-bold">1553</div>
                            <div class="text-muted small">Available 24/7 — Free & Confidential</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:#fef2f2;">
                            <div class="fw-semibold small text-danger mb-1"><i class="bi bi-heart-fill me-1"></i>In Touch Community Services</div>
                            <div class="fs-5 fw-bold">(02) 8893-7603</div>
                            <div class="text-muted small">Emotional crisis support</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:#fef2f2;">
                            <div class="fw-semibold small text-danger mb-1"><i class="bi bi-building me-1"></i>HOPELINE Philippines</div>
                            <div class="fs-5 fw-bold">02-804-4673</div>
                            <div class="text-muted small">Mental health helpline</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:#fef2f2;">
                            <div class="fw-semibold small text-danger mb-1"><i class="bi bi-person-heart me-1"></i>School CARE Center</div>
                            <div class="fs-5 fw-bold">Contact Your Counselor</div>
                            <div class="text-muted small">Your school's guidance office</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Actions -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-lightbulb me-2" style="color:#20B2AA;"></i>Recommended Steps</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('student.appointments.create') }}" class="text-decoration-none">
                            <div class="p-3 rounded-3 h-100 text-center border" style="transition:all 0.2s;" onmouseover="this.style.borderColor='#20B2AA'" onmouseout="this.style.borderColor='#dee2e6'">
                                <i class="bi bi-calendar-heart fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                                <div class="fw-semibold small">Book a Counseling Session</div>
                                <div class="text-muted" style="font-size:0.75rem;">Talk to a professional counselor</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('student.concerns.create') }}" class="text-decoration-none">
                            <div class="p-3 rounded-3 h-100 text-center border" style="transition:all 0.2s;" onmouseover="this.style.borderColor='#20B2AA'" onmouseout="this.style.borderColor='#dee2e6'">
                                <i class="bi bi-chat-heart fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                                <div class="fw-semibold small">Submit a Concern</div>
                                <div class="text-muted" style="font-size:0.75rem;">Share what's bothering you</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('student.resources') }}" class="text-decoration-none">
                            <div class="p-3 rounded-3 h-100 text-center border" style="transition:all 0.2s;" onmouseover="this.style.borderColor='#20B2AA'" onmouseout="this.style.borderColor='#dee2e6'">
                                <i class="bi bi-journal-heart fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                                <div class="fw-semibold small">Self-Help Resources</div>
                                <div class="text-muted" style="font-size:0.75rem;">Guides and coping strategies</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-house me-1"></i>Back to Dashboard
            </a>
            <a href="{{ route('student.kamustaka') }}" class="btn text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:50px;">
                <i class="bi bi-arrow-repeat me-1"></i>Check In Again
            </a>
        </div>
    </div>
</div>
@endsection

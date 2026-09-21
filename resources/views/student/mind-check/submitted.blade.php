@extends('layouts.dashboard')

@section('title', 'Assessment Submitted')

@section('content')
@include('student.partials.modern-styles')

<div class="container" style="max-width: 700px; margin-top: 3rem;">
    <!-- Success Icon Animation -->
    <div class="text-center mb-4">
        <div class="success-checkmark mx-auto mb-4">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>
    </div>

    <!-- Success Card -->
    <div class="modern-card text-center" style="padding: 2.5rem 2rem;">
        <h2 class="fw-bold mb-3" style="color: #111827; font-size: 1.75rem;">
            Assessment Submitted Successfully!
        </h2>
        
        <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.6;">
            Thank you for completing your mental health assessment. Your responses have been securely submitted to the CARE Team counselors for review.
        </p>

        <!-- What Happens Next -->
        <div class="alert mb-4" style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(20, 94, 56, 0.08)); border: none; border-radius: 12px; border-left: 4px solid var(--green); text-align: left;">
            <h6 class="fw-bold mb-3" style="color: var(--green);">
                <i class="bi bi-info-circle-fill me-2"></i>What Happens Next?
            </h6>
            <ul class="mb-0" style="color: #374151; font-size: 0.9rem; line-height: 1.8;">
                <li>A counselor will carefully review your assessment responses</li>
                <li>You'll receive a notification once the review is complete</li>
                <li>The counselor may reach out if they feel additional support would be helpful</li>
                <li>All your information remains confidential and secure</li>
            </ul>
        </div>

        <!-- Confidentiality Notice -->
        <div class="d-flex align-items-center justify-content-center gap-3 p-3 mb-4" 
             style="background: rgba(59, 130, 246, 0.06); border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.15);">
            <i class="bi bi-shield-lock-fill" style="color: #3b82f6; font-size: 1.5rem;"></i>
            <div class="text-start">
                <div class="fw-semibold" style="color: #1e293b; font-size: 0.9rem;">Your Privacy is Protected</div>
                <small class="text-muted" style="font-size: 0.8rem;">Only authorized CARE Team counselors can access your assessment</small>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2" style="max-width: 400px; margin: 0 auto;">
            <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-primary" style="justify-content: center;">
                <i class="bi bi-clock-history"></i>
                <span>View Assessment History</span>
            </a>
            
            <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-secondary" style="justify-content: center;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Mind Check</span>
            </a>

            <a href="{{ route('student.dashboard') }}" class="modern-btn modern-btn-secondary" style="justify-content: center;">
                <i class="bi bi-house"></i>
                <span>Go to Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Need Immediate Help -->
    <div class="modern-card mt-3" style="background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.15);">
        <div class="text-center">
            <h6 class="fw-bold mb-2" style="color: #111827;">
                <i class="bi bi-telephone-fill me-2" style="color: #ef4444;"></i>
                Need Immediate Support?
            </h6>
            <p class="small text-muted mb-3">If you're experiencing a crisis or need urgent help:</p>
            <div class="d-flex justify-content-center gap-4 flex-wrap">
                <div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">National Crisis Hotline</small>
                    <strong style="color: #ef4444; font-size: 1rem;">1553</strong>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">USAP Hotline</small>
                    <strong style="color: #ef4444; font-size: 1rem;">0917-899-USAP</strong>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('student.connect') }}" class="btn btn-sm" style="background: #ef4444; color: white; border-radius: 8px; padding: 0.5rem 1.25rem; font-weight: 600; font-size: 0.85rem;">
                    <i class="bi bi-calendar-plus me-1"></i>
                    Book Urgent Appointment
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Success Checkmark Animation */
    .success-checkmark {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid var(--green);
        animation: scaleCheckmark 0.3s ease-in-out 0.9s both;
    }

    .success-checkmark .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid var(--green);
    }

    .success-checkmark .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .success-checkmark .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotateCircle 4.25s ease-in;
    }

    .success-checkmark .icon-line {
        height: 5px;
        background-color: var(--green);
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .success-checkmark .icon-line.line-tip {
        top: 43px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: iconLineTip 0.75s;
    }

    .success-checkmark .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: iconLineLong 0.75s;
    }

    .success-checkmark .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(30, 122, 74, .2);
    }

    .success-checkmark .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #fff;
    }

    @keyframes rotateCircle {
        0% { transform: rotate(-45deg); }
        5% { transform: rotate(-45deg); }
        12% { transform: rotate(-405deg); }
        100% { transform: rotate(-405deg); }
    }

    @keyframes iconLineTip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: -8px; top: 37px; }
        84% { width: 17px; left: 21px; top: 48px; }
        100% { width: 25px; left: 14px; top: 43px; }
    }

    @keyframes iconLineLong {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0px; top: 35px; }
        100% { width: 47px; right: 8px; top: 38px; }
    }

    @keyframes scaleCheckmark {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
</style>
@endsection

@extends('layouts.dashboard')
@section('title', 'Kamusta Ka?')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <a href="{{ route('student.dashboard') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="modern-page-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Kamusta Ka? 🌿</h1>
            <p class="modern-page-subtitle">Your emotional wellness check-in</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="modern-card" style="padding: 2.5rem; text-align: center;">
            <div style="margin-bottom: 1rem;">
                <div class="modern-section-icon modern-page-icon-green" style="width: 60px; height: 60px; font-size: 1.75rem; margin: 0 auto 1rem;">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
            </div>
            <h4 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">How are you feeling today?</h4>
            <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 2.5rem;">Your feelings are valid. This is a safe space — select how you feel right now.</p>

            <form action="{{ route('student.kamustaka.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 2rem;">
                    <div>
                        <label style="cursor: pointer; width: 100%; height: 100%;">
                            <input type="radio" name="mood" value="okay" class="d-none mood-radio" id="moodOkay">
                            <div class="mood-card modern-card" id="cardOkay" style="padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem; min-height: 160px; transition: all 0.2s;">
                                <span style="font-size: 3rem;">😊</span>
                                <div style="font-size: 1rem; font-weight: 700; color: var(--navy);">Okay</div>
                                <small style="font-size: 0.85rem; color: var(--text-muted);">I'm doing well</small>
                            </div>
                        </label>
                    </div>
                    <div>
                        <label style="cursor: pointer; width: 100%; height: 100%;">
                            <input type="radio" name="mood" value="not_sure" class="d-none mood-radio" id="moodNotSure">
                            <div class="mood-card modern-card" id="cardNotSure" style="padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem; min-height: 160px; transition: all 0.2s;">
                                <span style="font-size: 3rem;">😐</span>
                                <div style="font-size: 1rem; font-weight: 700; color: var(--navy);">Not Sure</div>
                                <small style="font-size: 0.85rem; color: var(--text-muted);">I'm unsure how I feel</small>
                            </div>
                        </label>
                    </div>
                    <div>
                        <label style="cursor: pointer; width: 100%; height: 100%;">
                            <input type="radio" name="mood" value="not_okay" class="d-none mood-radio" id="moodNotOkay">
                            <div class="mood-card modern-card" id="cardNotOkay" style="padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem; min-height: 160px; transition: all 0.2s;">
                                <span style="font-size: 3rem;">😔</span>
                                <div style="font-size: 1rem; font-weight: 700; color: var(--navy);">Not Okay</div>
                                <small style="font-size: 0.85rem; color: var(--text-muted);">I need support</small>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="modern-btn modern-btn-primary d-none" style="padding: 0.75rem 2.5rem; font-size: 0.95rem; border-radius: 50px;">
                    <i class="bi bi-arrow-right-circle"></i>
                    <span>Continue</span>
                </button>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(13, 45, 82, 0.1);">
                <small style="font-size: 0.85rem; color: var(--text-muted);">
                    <i class="bi bi-shield-lock"></i>
                    Your response is confidential and helps us support you better.
                </small>
            </div>
        </div>
    </div>
</div>

<style>
.mood-card { background: rgba(248, 250, 252, 0.5); }
.mood-card:hover { 
    background: rgba(16, 185, 129, 0.08); 
    border-color: #10b981 !important; 
    transform: translateY(-4px); 
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
}
.mood-card.selected { 
    background: rgba(16, 185, 129, 0.12) !important; 
    border-color: #10b981 !important; 
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
    transform: scale(1.02);
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(3, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
document.querySelectorAll('.mood-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.mood-card').forEach(c => c.classList.remove('selected'));
        this.nextElementSibling.classList.add('selected');
        document.getElementById('submitBtn').classList.remove('d-none');
    });
});
</script>
@endsection

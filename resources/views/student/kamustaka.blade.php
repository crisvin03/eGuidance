@extends('layouts.dashboard')
@section('title', 'Kamusta Ka?')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Kamusta Ka? <span style="font-size:1.3rem;">🌿</span></h5>
        <small class="text-muted">Your emotional wellness check-in</small>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm" style="border-radius:20px;">
            <div class="card-body p-5 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:70px;height:70px;background:linear-gradient(135deg,#20B2AA,#008B8B);">
                        <i class="bi bi-heart-pulse-fill text-white fs-3"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-2">How are you feeling today?</h4>
                <p class="text-muted mb-5">Your feelings are valid. This is a safe space — select how you feel right now.</p>

                <form action="{{ route('student.kamustaka.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="w-100 h-100" style="cursor:pointer;">
                                <input type="radio" name="mood" value="okay" class="d-none mood-radio" id="moodOkay">
                                <div class="mood-card p-4 rounded-4 border h-100 d-flex flex-column align-items-center justify-content-center gap-2"
                                     id="cardOkay" style="transition:all 0.2s;min-height:140px;">
                                    <span style="font-size:3rem;">😊</span>
                                    <div class="fw-bold">Okay</div>
                                    <small class="text-muted">I'm doing well</small>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="w-100 h-100" style="cursor:pointer;">
                                <input type="radio" name="mood" value="not_sure" class="d-none mood-radio" id="moodNotSure">
                                <div class="mood-card p-4 rounded-4 border h-100 d-flex flex-column align-items-center justify-content-center gap-2"
                                     id="cardNotSure" style="transition:all 0.2s;min-height:140px;">
                                    <span style="font-size:3rem;">😐</span>
                                    <div class="fw-bold">Not Sure</div>
                                    <small class="text-muted">I'm unsure how I feel</small>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="w-100 h-100" style="cursor:pointer;">
                                <input type="radio" name="mood" value="not_okay" class="d-none mood-radio" id="moodNotOkay">
                                <div class="mood-card p-4 rounded-4 border h-100 d-flex flex-column align-items-center justify-content-center gap-2"
                                     id="cardNotOkay" style="transition:all 0.2s;min-height:140px;">
                                    <span style="font-size:3rem;">😔</span>
                                    <div class="fw-bold">Not Okay</div>
                                    <small class="text-muted">I need support</small>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" class="btn text-white px-5 py-2 fw-semibold d-none"
                            style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:50px;">
                        <i class="bi bi-arrow-right-circle me-2"></i>Continue
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-shield-lock me-1"></i>
                        Your response is confidential and helps us support you better.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.mood-card { background: #f8fafc; }
.mood-card:hover { background: rgba(32,178,170,0.06); border-color: #20B2AA !important; transform: translateY(-4px); box-shadow: 0 8px 20px rgba(32,178,170,0.15); }
.mood-card.selected { background: rgba(32,178,170,0.1) !important; border-color: #20B2AA !important; box-shadow: 0 0 0 3px rgba(32,178,170,0.3); }
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

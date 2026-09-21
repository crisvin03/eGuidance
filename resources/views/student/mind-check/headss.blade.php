@extends('layouts.dashboard')

@section('title', 'HEADSS Assessment')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-heart"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">HEADSS Rapid Questionnaire</h1>
            <p class="modern-page-subtitle">Questions on Home, Education, Employment, Activities, Substance Use, Reproductive Health</p>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="modern-alert modern-alert-info mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--green);">Sagutin ng tapat ang mga sumusunod na katanonungan</h6>
        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
            Ang sagot ay CONFIDENTIAL. Please answer honestly and openly.
        </p>
    </div>
</div>

<form method="POST" action="{{ route('student.mind-check.headss.store') }}">
    @csrf
    
    <div class="row" style="gap: 0;">
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Personal Information</h3>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Pangalan</span>
                        </label>
                        <input type="text" name="pangalan" class="form-control modern-form-control @error('pangalan') is-invalid @enderror" 
                               value="{{ old('pangalan', auth()->user()->name) }}" required>
                        @error('pangalan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Kasarian</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kasarian" id="lalake" value="Lalake" {{ old('kasarian') == 'Lalake' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="lalake">Lalake</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kasarian" id="babae" value="Babae" {{ old('kasarian') == 'Babae' ? 'checked' : '' }}>
                                <label class="form-check-label" for="babae">Babae</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Edad</span>
                        </label>
                        <input type="number" name="edad" class="form-control modern-form-control @error('edad') is-invalid @enderror" 
                               value="{{ old('edad') }}" required min="10" max="25">
                        @error('edad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Kapanganakan</span>
                        </label>
                        <input type="date" name="kapanganakan" class="form-control modern-form-control @error('kapanganakan') is-invalid @enderror" 
                               value="{{ old('kapanganakan') }}" required>
                        @error('kapanganakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Katayuan</span>
                        </label>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="katayuan" id="walang_asawa" value="Walang Asawa" {{ old('katayuan') == 'Walang Asawa' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="walang_asawa">Walang Asawa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="katayuan" id="may_asawa" value="May Asawa, Kasal" {{ old('katayuan') == 'May Asawa, Kasal' ? 'checked' : '' }}>
                                <label class="form-check-label" for="may_asawa">May Asawa, Kasal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="katayuan" id="live_in" value="Live-in, Hindi Kasal" {{ old('katayuan') == 'Live-in, Hindi Kasal' ? 'checked' : '' }}>
                                <label class="form-check-label" for="live_in">Live-in, Hindi Kasal</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Trabaho</span>
                        </label>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trabaho" id="estudyante" value="Estudyante" {{ old('trabaho') == 'Estudyante' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="estudyante">Estudyante</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trabaho" id="nagtatrabaho" value="Nagtatrabaho" {{ old('trabaho') == 'Nagtatrabaho' ? 'checked' : '' }}>
                                <label class="form-check-label" for="nagtatrabaho">Nagtatrabaho</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trabaho" id="estudyante_nagtatrabaho" value="Estudyante at Nagtatrabaho" {{ old('trabaho') == 'Estudyante at Nagtatrabaho' ? 'checked' : '' }}>
                                <label class="form-check-label" for="estudyante_nagtatrabaho">Estudyante at Nagtatrabaho</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trabaho" id="wala" value="Wala" {{ old('trabaho') == 'Wala' ? 'checked' : '' }}>
                                <label class="form-check-label" for="wala">Wala</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Tirahan</span>
                    </label>
                    <input type="text" name="tirahan" class="form-control modern-form-control @error('tirahan') is-invalid @enderror" 
                           value="{{ old('tirahan') }}" required placeholder="Enter your address">
                    @error('tirahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-0">
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Cellphone</span>
                        </label>
                        <input type="text" name="cellphone" class="form-control modern-form-control @error('cellphone') is-invalid @enderror" 
                               value="{{ old('cellphone') }}" placeholder="09XX XXX XXXX">
                        @error('cellphone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>E'mail</span>
                        </label>
                        <input type="email" name="email" class="form-control modern-form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', auth()->user()->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Landline</span>
                        </label>
                        <input type="text" name="landline" class="form-control modern-form-control @error('landline') is-invalid @enderror" 
                               value="{{ old('landline') }}" placeholder="(02) XXXX XXXX">
                        @error('landline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- HEADSS Questions -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">HEADSS Questionnaire</h3>
                </div>

                @php
                $questions = [
                    ['num' => 1, 'text' => 'Ikaw ba ay nakakaranas ng problema sa inyong bahay?'],
                    ['num' => 2, 'text' => 'Nakaranas ka ba ng bullying o pananakit sa paaralan o sa trabaho?'],
                    ['num' => 3, 'text' => 'May pagkakatoon ba na seryoso mong naisip na wakasan ang iyong buhay?'],
                    ['num' => 4, 'text' => 'Naninigarilyo ka ba?'],
                    ['num' => 5, 'text' => 'Umiinom ka ba ng alak?'],
                    ['num' => 6, 'text' => 'Ikaw ba ay nakaranas ng magka boyfriend / girlfriend?'],
                    ['num' => 7, 'text' => 'Ikaw ba ay nakaranas ng makipag sex o makipagtalik?'],
                    ['num' => 8, 'text' => 'Nakaranas ka ba na ikaw ay pinilit makipag sex?'],
                    ['num' => 9, 'text' => 'Ikaw ba ay nakaranas nang mabuntis, o makabuntis?'],
                    ['num' => 10, 'text' => 'Gusto mo bang mag pa counsel o komunsulta para matulungan ka?']
                ];
                @endphp

                @foreach($questions as $q)
                <div style="padding: 1rem 0; border-bottom: 1px solid rgba(30, 122, 74, 0.08); {{ $loop->last ? 'border-bottom: none;' : '' }}">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                        <label style="font-size: 0.95rem; color: var(--navy); margin: 0; flex: 1;">
                            {{ $q['num'] }}. {{ $q['text'] }}
                        </label>
                        <div style="display: flex; gap: 2rem; flex-shrink: 0;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="responses[q{{ $q['num'] }}]" 
                                       id="q{{ $q['num'] }}_hindi" value="Hindi" 
                                       {{ old('responses.q' . $q['num']) == 'Hindi' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="q{{ $q['num'] }}_hindi" style="font-size: 0.9rem;">
                                    Hindi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="responses[q{{ $q['num'] }}]" 
                                       id="q{{ $q['num'] }}_oo" value="Oo" 
                                       {{ old('responses.q' . $q['num']) == 'Oo' ? 'checked' : '' }}>
                                <label class="form-check-label" for="q{{ $q['num'] }}_oo" style="font-size: 0.9rem;">
                                    Oo
                                </label>
                            </div>
                        </div>
                    </div>
                    @error('responses.q' . $q['num'])
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-check-circle"></i>
                    <span>Submit Assessment</span>
                </button>
                <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-outline" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Mind Check</span>
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Progress -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Assessment Topics</h6>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-house-heart-fill" style="color: var(--green); font-size: 1.1rem;"></i>
                        <small style="font-size: 0.875rem; color: var(--text-muted);">Home</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-book-fill" style="color: var(--green); font-size: 1.1rem;"></i>
                        <small style="font-size: 0.875rem; color: var(--text-muted);">Education</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-briefcase" style="color: var(--green); font-size: 1.1rem;"></i>
                        <small style="font-size: 0.875rem; color: var(--text-muted);">Employment</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-people-fill" style="color: var(--green); font-size: 1.1rem;"></i>
                        <small style="font-size: 0.875rem; color: var(--text-muted);">Activities</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-shield-x" style="color: var(--green); font-size: 1.1rem;"></i>
                        <small style="font-size: 0.875rem; color: var(--text-muted);">Substance Use</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-heart" style="color: var(--green); font-size: 1.1rem;"></i>
                        <small style="font-size: 0.875rem; color: var(--text-muted);">Reproductive Health</small>
                    </div>
                </div>
            </div>

            <!-- Confidentiality -->
            <div class="modern-card" style="padding: 1.5rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); text-align: center;">
                <div style="margin-bottom: 1rem;">
                    <i class="bi bi-shield-check" style="font-size: 2.5rem; color: var(--green);"></i>
                </div>
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Your Privacy Matters</h6>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
                    Ang iyong mga sagot ay CONFIDENTIAL at makikita lamang ng CARE Team counselors.
                </p>
            </div>
        </div>
    </div>
</form>

<style>
@media (max-width: 992px) {
    .col-lg-4 {
        margin-top: 1.5rem;
    }
}

@media (max-width: 768px) {
    .d-flex.gap-3.flex-wrap {
        flex-direction: column;
    }
    
    .modern-btn {
        width: 100%;
    }
}
</style>
@endsection

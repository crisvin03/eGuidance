@extends('layouts.dashboard')

@section('title', 'GAD-7 Assessment')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-emoji-frown"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">GAD-7 Anxiety Screening</h1>
            <p class="modern-page-subtitle">Generalized Anxiety Disorder 7-item scale</p>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="modern-alert modern-alert-info mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--green);">Over the last 2 weeks...</h6>
        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
            How often have you been bothered by the following problems? Select the answer that best describes your experience.
        </p>
    </div>
</div>

<form method="POST" action="{{ route('student.mind-check.gad7.store') }}" id="gad7Form">
    @csrf
    
    <div class="row" style="gap: 0;">
        <div class="col-lg-8">
            @php
            $questions = [
                ['q' => 'q1', 'text' => 'Feeling nervous, anxious, or on edge'],
                ['q' => 'q2', 'text' => 'Not being able to stop or control worrying'],
                ['q' => 'q3', 'text' => 'Worrying too much about different things'],
                ['q' => 'q4', 'text' => 'Trouble relaxing'],
                ['q' => 'q5', 'text' => "Being so restless that it's hard to sit still"],
                ['q' => 'q6', 'text' => 'Becoming easily annoyed or irritable'],
                ['q' => 'q7', 'text' => 'Feeling afraid as if something awful might happen']
            ];
            @endphp

            @foreach($questions as $index => $question)
            <div class="modern-card mb-3" style="padding: 1.5rem;">
                <h6 style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem;">
                    {{ $index + 1 }}. {{ $question['text'] }}
                </h6>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach([['val' => 0, 'label' => 'Not at all'], ['val' => 1, 'label' => 'Several days'], ['val' => 2, 'label' => 'More than half the days'], ['val' => 3, 'label' => 'Nearly every day']] as $option)
                    <label class="question-option" style="padding: 0.875rem 1rem; border: 2px solid rgba(30, 122, 74, 0.12); border-radius: 12px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="responses[{{ $question['q'] }}]" value="{{ $option['val'] }}" class="form-check-input" required style="margin: 0; cursor: pointer;">
                        <span style="font-size: 0.9rem; color: var(--navy);">{{ $option['label'] }}</span>
                    </label>
                    @endforeach
                </div>
                @error('responses.' . $question['q'])
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>
            @endforeach

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
            <!-- Score Preview -->
            <div class="modern-card mb-4" style="padding: 1.5rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); text-align: center;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Your Score</h6>
                <div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--green);" id="totalScore">0</div>
                <small style="color: var(--text-muted);">out of 21</small>
                <hr style="margin: 1rem 0; border-color: rgba(30, 122, 74, 0.2);">
                <div id="scoreInterpretation">
                    <div style="font-weight: 600; margin-bottom: 0.25rem; color: var(--navy);">Minimal Anxiety</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Score: 0-4</div>
                </div>
            </div>

            <!-- Progress -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Questions Answered</h6>
                <div style="height: 8px; border-radius: 8px; background: rgba(30, 122, 74, 0.12); overflow: hidden; margin-bottom: 0.5rem;">
                    <div id="progressBar" style="height: 100%; width: 0%; background: var(--green); transition: width 0.3s;"></div>
                </div>
                <small style="color: var(--text-muted);"><span id="answeredCount">0</span> of 7 completed</small>
            </div>

            <!-- Scoring Guide -->
            <div class="modern-card" style="padding: 1.5rem;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Score Guide</h6>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(30, 122, 74, 0.12);">
                        <small style="color: var(--text-muted);">0-4</small>
                        <small style="font-weight: 600; color: var(--navy);">Minimal</small>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(30, 122, 74, 0.12);">
                        <small style="color: var(--text-muted);">5-9</small>
                        <small style="font-weight: 600; color: var(--navy);">Mild</small>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(30, 122, 74, 0.12);">
                        <small style="color: var(--text-muted);">10-14</small>
                        <small style="font-weight: 600; color: var(--navy);">Moderate</small>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <small style="color: var(--text-muted);">15-21</small>
                        <small style="font-weight: 600; color: var(--navy);">Severe</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.question-option:hover {
    background: rgba(30, 122, 74, 0.05);
    border-color: var(--green) !important;
}
.question-option:has(input:checked) {
    background: rgba(30, 122, 74, 0.08);
    border-color: var(--green) !important;
}
.question-option:has(input:checked) span {
    color: var(--green);
    font-weight: 600;
}

@media (max-width: 992px) {
    .col-lg-4 {
        margin-top: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('gad7Form');
    const totalScoreEl = document.getElementById('totalScore');
    const scoreInterpretationEl = document.getElementById('scoreInterpretation');
    const progressBar = document.getElementById('progressBar');
    const answeredCount = document.getElementById('answeredCount');
    
    const interpretations = [
        { max: 4, level: 'Minimal Anxiety', range: '0-4' },
        { max: 9, level: 'Mild Anxiety', range: '5-9' },
        { max: 14, level: 'Moderate Anxiety', range: '10-14' },
        { max: 21, level: 'Severe Anxiety', range: '15-21' }
    ];
    
    function calculateScore() {
        let total = 0;
        let answered = 0;
        
        for (let i = 1; i <= 7; i++) {
            const selected = form.querySelector(`input[name="responses[q${i}]"]:checked`);
            if (selected) {
                total += parseInt(selected.value);
                answered++;
            }
        }
        
        totalScoreEl.textContent = total;
        answeredCount.textContent = answered;
        progressBar.style.width = (answered / 7 * 100) + '%';
        
        const interpretation = interpretations.find(i => total <= i.max);
        if (interpretation) {
            scoreInterpretationEl.innerHTML = `
                <div style="font-weight: 600; margin-bottom: 0.25rem; color: var(--navy);">${interpretation.level}</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Score: ${interpretation.range}</div>
            `;
        }
    }
    
    form.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', calculateScore);
    });
});
</script>
@endsection

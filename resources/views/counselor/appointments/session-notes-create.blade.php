@extends('layouts.dashboard')

@section('title', 'Add Session Note')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('counselor.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="fw-bold mb-0">Add Session Note</h5>
                        <small class="text-muted">Document your counseling session with {{ $appointment->student->name }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body px-4 pb-4">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('counselor.appointments.session-notes.store', $appointment) }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Session Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('session_type') is-invalid @enderror" name="session_type" required>
                            <option value="">Select session type...</option>
                            <option value="individual" {{ old('session_type') == 'individual' ? 'selected' : '' }}>Individual Counseling</option>
                            <option value="group" {{ old('session_type') == 'group' ? 'selected' : '' }}>Group Counseling</option>
                            <option value="crisis" {{ old('session_type') == 'crisis' ? 'selected' : '' }}>Crisis Intervention</option>
                            <option value="follow_up" {{ old('session_type') == 'follow_up' ? 'selected' : '' }}>Follow-up Session</option>
                            <option value="assessment" {{ old('session_type') == 'assessment' ? 'selected' : '' }}>Assessment</option>
                            <option value="referral" {{ old('session_type') == 'referral' ? 'selected' : '' }}>Referral Consultation</option>
                        </select>
                        @error('session_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Session Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('session_date') is-invalid @enderror" 
                               name="session_date" 
                               value="{{ old('session_date', $appointment->appointment_date->format('Y-m-d\TH:i')) }}" 
                               required>
                        @error('session_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Session Notes <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  name="notes" 
                                  rows="8" 
                                  required
                                  placeholder="Document the key points discussed, student's concerns, observations, and progress...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Be detailed but maintain professional documentation standards</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Recommendations & Action Plan</label>
                        <textarea class="form-control @error('recommendations') is-invalid @enderror" 
                                  name="recommendations" 
                                  rows="5"
                                  placeholder="Recommended interventions, follow-up actions, referrals, or strategies discussed...">{{ old('recommendations') }}</textarea>
                        @error('recommendations')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Include next steps and any resources provided</small>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_confidential" id="is_confidential" 
                                   value="1" {{ old('is_confidential') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_confidential">
                                <i class="bi bi-lock-fill me-1"></i>Mark as Confidential
                            </label>
                            <small class="text-muted d-block ms-4">Highly sensitive information that requires additional privacy protection</small>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('counselor.appointments.show', $appointment) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn text-white fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                            <i class="bi bi-check-circle me-1"></i>Save Session Note
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Appointment Info Card -->
        <div class="card mt-3 border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2" style="color:#20B2AA;"></i>Appointment Information</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Student</small>
                        <strong>{{ $appointment->student->name }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Scheduled Date</small>
                        <strong>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</strong>
                    </div>
                    @if($appointment->concern)
                    <div class="col-12">
                        <small class="text-muted d-block">Related Concern</small>
                        <strong>{{ $appointment->concern->title }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

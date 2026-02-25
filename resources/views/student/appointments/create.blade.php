@extends('layouts.dashboard')

@section('title', 'Schedule Appointment')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Schedule an Appointment</h5>
                <p class="card-text text-muted">Book a counseling session with one of our guidance counselors.</p>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student.appointments.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="counselor_id" class="form-label">
                            <i class="bi bi-person-check me-2"></i>Counselor
                        </label>
                        <select id="counselor_id" class="form-select @error('counselor_id') is-invalid @enderror" name="counselor_id" required>
                            <option value="">Select a counselor</option>
                            @foreach($counselors as $counselor)
                                <option value="{{ $counselor->id }}" {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('counselor_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="appointment_date" class="form-label">
                            <i class="bi bi-calendar3 me-2"></i>Preferred Date & Time
                        </label>
                        <input id="appointment_date" type="datetime-local"
                            class="form-control @error('appointment_date') is-invalid @enderror"
                            name="appointment_date"
                            value="{{ old('appointment_date') }}"
                            min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                            required>
                        <div class="form-text">Select a date and time at least 1 hour from now.</div>
                        @error('appointment_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label">
                            <i class="bi bi-chat-left-text me-2"></i>Notes <span class="text-muted">(Optional)</span>
                        </label>
                        <textarea id="notes"
                            class="form-control @error('notes') is-invalid @enderror"
                            name="notes" rows="4"
                            placeholder="Any specific concerns or topics you'd like to discuss?">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-calendar-check me-2"></i>Schedule Appointment
                        </button>
                        <a href="{{ route('student.appointments.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Appointment Guidelines</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                    <small class="text-muted">Choose a counselor that best fits your needs</small>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                    <small class="text-muted">Select a date and time convenient for you</small>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                    <small class="text-muted">Add notes to help the counselor prepare</small>
                </div>
                <div class="d-flex align-items-start">
                    <i class="bi bi-info-circle text-primary me-2 mt-1"></i>
                    <small class="text-muted">You can reschedule or cancel anytime before the session</small>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title">Available Counselors</h6>
            </div>
            <div class="card-body">
                @foreach($counselors as $counselor)
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="user-avatar">
                            {{ strtoupper(substr($counselor->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-semibold small">{{ $counselor->name }}</div>
                            <small class="text-muted">Guidance Counselor</small>
                        </div>
                    </div>
                @endforeach
                @if($counselors->isEmpty())
                    <p class="text-muted text-center small">No counselors available at the moment.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

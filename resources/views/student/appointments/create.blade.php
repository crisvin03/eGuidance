@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Schedule Appointment</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.appointments.store') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="counselor_id" class="col-md-4 col-form-label text-md-end">Counselor</label>
                            <div class="col-md-6">
                                <select id="counselor_id" class="form-select @error('counselor_id') is-invalid @enderror" name="counselor_id" required>
                                    <option value="">Select a counselor</option>
                                    @foreach($counselors as $counselor)
                                        <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                                    @endforeach
                                </select>
                                @error('counselor_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="appointment_date" class="col-md-4 col-form-label text-md-end">Appointment Date & Time</label>
                            <div class="col-md-6">
                                <input id="appointment_date" type="datetime-local" class="form-control @error('appointment_date') is-invalid @enderror" name="appointment_date" required>
                                @error('appointment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="notes" class="col-md-4 col-form-label text-md-end">Notes (Optional)</label>
                            <div class="col-md-6">
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3" placeholder="Any specific concerns or topics you'd like to discuss?">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Schedule Appointment
                                </button>
                                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

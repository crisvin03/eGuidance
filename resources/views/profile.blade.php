@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                {{-- Profile Photo with Upload Form --}}
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="photoUploadForm">
                    @csrf
                    @method('PUT')
                    {{-- Pass existing user data as hidden fields --}}
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                    @if(Auth::user()->isStudent())
                        <input type="hidden" name="lrn" value="{{ Auth::user()->lrn ?? '' }}">
                        <input type="hidden" name="grade_level" value="{{ Auth::user()->grade_level ?? '' }}">
                        <input type="hidden" name="section" value="{{ Auth::user()->section ?? '' }}">
                        <input type="hidden" name="adviser" value="{{ Auth::user()->adviser ?? '' }}">
                        <input type="hidden" name="contact_person" value="{{ Auth::user()->contact_person ?? '' }}">
                        <input type="hidden" name="contact_number" value="{{ Auth::user()->contact_number ?? '' }}">
                    @endif
                    @if(Auth::user()->isTeacher())
                        <input type="hidden" name="advisee" value="{{ Auth::user()->advisee ?? '' }}">
                    @endif
                    <input type="hidden" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                    <input type="hidden" name="date_of_birth" value="{{ Auth::user()->date_of_birth ?? '' }}">
                    <input type="hidden" name="gender" value="{{ Auth::user()->gender ?? '' }}">
                    <input type="hidden" name="address" value="{{ Auth::user()->address ?? '' }}">
                    <input type="file" id="photoInput" name="profile_photo" accept="image/*" class="d-none" onchange="document.getElementById('photoUploadForm').submit();">
                </form>
                
                <div class="mb-3 position-relative d-inline-block">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                             alt="Profile Photo"
                             class="rounded-circle border"
                             style="width:90px;height:90px;object-fit:cover;">
                    @else
                        <div class="user-avatar mx-auto d-flex align-items-center justify-content-center"
                             style="width:90px;height:90px;font-size:1.8rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <label for="photoInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                           style="width:28px;height:28px;cursor:pointer;" title="Click to upload photo">
                        <i class="bi bi-camera-fill" style="font-size:.75rem;"></i>
                    </label>
                </div>
                
                @error('profile_photo')
                    <div class="alert alert-danger alert-dismissible fade show py-2 mt-2">
                        <small>{{ $message }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @enderror
                <h5 class="card-title">{{ Auth::user()->name }}</h5>
                <p class="card-text text-muted">{{ ucfirst(Auth::user()->role->name) }}</p>
                <div class="mt-2">
                    <span class="badge {{ Auth::user()->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                @if(Auth::user()->profile_photo)
                <form method="POST" action="{{ route('profile.photo.remove') }}" class="mt-2">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Remove Photo
                    </button>
                </form>
                @endif
                
                @if(Auth::user()->isStudent())
                <div class="mt-3">
                    <a href="{{ route('student.virtual-id') }}" class="btn btn-sm w-100 text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                        <i class="bi bi-person-badge me-1"></i>View Virtual ID
                    </a>
                </div>
                @endif
                
                @if(Auth::user()->isTeacher())
                <div class="mt-3">
                    <a href="{{ route('teacher.virtual-id') }}" class="btn btn-sm w-100 text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                        <i class="bi bi-person-badge me-1"></i>View Virtual ID
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title">Quick Stats</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->isStudent()) <!-- Student -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Concerns Submitted</span>
                        <strong>{{ App\Models\Concern::where('student_id', Auth::user()->id)->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Appointments</span>
                        <strong>{{ App\Models\Appointment::where('student_id', Auth::user()->id)->count() }}</strong>
                    </div>
                @elseif(Auth::user()->isCounselor()) <!-- Counselor -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Concerns Handled</span>
                        <strong>{{ App\Models\Concern::count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Appointments</span>
                        <strong>{{ App\Models\Appointment::where('counselor_id', Auth::user()->id)->count() }}</strong>
                    </div>
                @else <!-- Admin -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Users</span>
                        <strong>{{ App\Models\User::count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Concerns</span>
                        <strong>{{ App\Models\Concern::count() }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        @if($errors->any() && !$errors->has('current_password') && !$errors->has('password'))
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>
                    
                    @if(Auth::user()->isStudent())
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Complete your profile:</strong> Please fill in all required fields (Photo, LRN, Grade Level, Section, Adviser, Emergency Contact Person, and Contact Number) to access all features including your Virtual ID.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lrn" class="form-label fw-semibold">LRN (Learner Reference Number) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lrn') is-invalid @enderror" id="lrn" name="lrn" value="{{ Auth::user()->lrn ?? '' }}" placeholder="12-digit Learner Reference Number" required>
                                @error('lrn')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="grade_level" class="form-label fw-semibold">Grade Level <span class="text-danger">*</span></label>
                                <select class="form-select @error('grade_level') is-invalid @enderror" id="grade_level" name="grade_level" required>
                                    <option value="">Select Grade Level</option>
                                    <option value="Grade 7"  {{ Auth::user()->grade_level == 'Grade 7'  ? 'selected' : '' }}>Grade 7</option>
                                    <option value="Grade 8"  {{ Auth::user()->grade_level == 'Grade 8'  ? 'selected' : '' }}>Grade 8</option>
                                    <option value="Grade 9"  {{ Auth::user()->grade_level == 'Grade 9'  ? 'selected' : '' }}>Grade 9</option>
                                    <option value="Grade 10" {{ Auth::user()->grade_level == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                                    <option value="Grade 11" {{ Auth::user()->grade_level == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                                    <option value="Grade 12" {{ Auth::user()->grade_level == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                                </select>
                                @error('grade_level')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="section" class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('section') is-invalid @enderror" id="section" name="section" value="{{ Auth::user()->section ?? '' }}" placeholder="e.g., Sampaguita, Narra" required>
                                @error('section')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="adviser" class="form-label fw-semibold">Adviser Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('adviser') is-invalid @enderror" id="adviser" name="adviser" value="{{ Auth::user()->adviser ?? '' }}" placeholder="Your class adviser's full name" required>
                                @error('adviser')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_person" class="form-label fw-semibold">Emergency Contact Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ Auth::user()->contact_person ?? '' }}" placeholder="Parent/Guardian Name" required>
                                @error('contact_person')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label fw-semibold">Emergency Contact Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ Auth::user()->contact_number ?? '' }}" placeholder="Parent/Guardian Phone Number" required>
                                @error('contact_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-3">
                    @endif
                    
                    @if(Auth::user()->isTeacher())
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="advisee" class="form-label">Advisee Class/Section</label>
                                <input type="text" class="form-control" id="advisee" name="advisee" value="{{ Auth::user()->advisee ?? '' }}" placeholder="e.g., Grade 9 - Mabini">
                                <small class="text-muted">The class/section you are advising</small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ Auth::user()->date_of_birth ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ Auth::user()->address ?? '' }}</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="location.reload()">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Change Password</h5>
            </div>
            <div class="card-body">
                @if($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->get('current_password') as $e)<li>{{ $e }}</li>@endforeach
                            @foreach($errors->get('password') as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-lock me-1"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

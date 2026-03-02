@extends('layouts.dashboard')

@section('title', 'Submit Concern')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Submit a Concern</h5>
                <p class="card-text text-muted">Share your concerns with our guidance counselors for support and assistance.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.concerns.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="category_id" class="form-label">
                            <i class="bi bi-tag me-2"></i>Category
                        </label>
                        <select id="category_id" class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="title" class="form-label">
                            <i class="bi bi-chat-dots me-2"></i>Title
                        </label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus placeholder="Brief summary of your concern">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="bi bi-text-paragraph me-2"></i>Description
                        </label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" required placeholder="Provide detailed information about your concern...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-paperclip me-2"></i>Attachment <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="file" id="attachment" name="attachment"
                               class="form-control @error('attachment') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                        <small class="text-muted">Accepted: JPG, PNG, GIF, PDF, DOC, DOCX &mdash; Max 5MB</small>
                        @error('attachment')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_anonymous" id="is_anonymous" value="1">
                                    <label class="form-check-label" for="is_anonymous">
                                        <i class="bi bi-incognito me-2"></i>
                                        Submit anonymously (hide my identity)
                                    </label>
                                </div>
                                <small class="text-muted">Your identity will be hidden from counselors, but they can still provide help.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>
                            Submit Concern
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Guidelines</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                    <small class="text-muted">Be specific and detailed in your description</small>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                    <small class="text-muted">Choose the most appropriate category</small>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                    <small class="text-muted">Anonymous concerns are completely confidential</small>
                </div>
                <div class="d-flex align-items-start">
                    <i class="bi bi-info-circle text-primary me-2 mt-1"></i>
                    <small class="text-muted">Counselors typically respond within 24-48 hours</small>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title">Support Available</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="bi bi-people" style="font-size: 2rem; color: #20B2AA;"></i>
                </div>
                <p class="text-center text-muted">
                    <strong>{{ App\Models\User::where('role_id', 2)->where('is_active', 1)->count() }}</strong><br>
                    Counselors available to help
                </p>
                <div class="text-center">
                    <small class="text-muted">Average response time: 24 hours</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

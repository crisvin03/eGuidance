@extends('layouts.dashboard')
@section('title', 'Intervention Guides')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Intervention Guides</h5>
    <small class="text-muted">Searchable guides and downloadable resources for classroom intervention and student support.</small>
</div>

<!-- Search & Filter -->
<form method="GET" action="{{ route('teacher.intervention-guides.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Search guides..." value="{{ $search }}">
            </div>
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ $category == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn w-100 text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
        </div>
    </div>
</form>

@if($guides->count())
    @php $grouped = $guides->groupBy('category'); @endphp
    @foreach($grouped as $cat => $catGuides)
        @php $first = $catGuides->first(); @endphp
        <h6 class="fw-bold text-muted text-uppercase mb-3 mt-4" style="letter-spacing:0.5px;">
            <i class="bi {{ $first->category_icon }} me-2"></i>{{ $first->category_label }}
        </h6>
        <div class="row g-3 mb-2">
            @foreach($catGuides as $guide)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <i class="bi {{ $guide->category_icon }} fs-5 mt-1" style="color:#20B2AA;"></i>
                            <h6 class="fw-semibold mb-0">{{ $guide->title }}</h6>
                        </div>
                        @if($guide->description)
                            <p class="text-muted small mb-3">{{ $guide->description }}</p>
                        @endif
                        @if($guide->content)
                            <div class="bg-light rounded-3 p-3 small mb-3 flex-fill" style="max-height:120px;overflow:hidden;position:relative;">
                                {{ Str::limit(strip_tags($guide->content), 200) }}
                                <div style="position:absolute;bottom:0;left:0;right:0;height:40px;background:linear-gradient(transparent,#f8f9fa);"></div>
                            </div>
                        @endif
                        <div class="mt-auto pt-2 d-flex gap-2">
                            @if($guide->file_path)
                                <a href="{{ asset('storage/' . $guide->file_path) }}" target="_blank"
                                   class="btn btn-sm text-white flex-fill" style="background:#20B2AA;">
                                    <i class="bi bi-download me-1"></i>Download
                                </a>
                            @else
                                <span class="badge bg-light text-muted py-2 px-3 small">Content only &mdash; no file</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
@else
    <!-- Placeholder when no guides are in the DB yet -->
    @php
        $placeholders = [
            ['icon' => 'bi-shield-exclamation', 'title' => 'Adult-to-Learner Protection Concern Protocol', 'desc' => 'Guidelines for handling adult-to-learner protection concerns in the school setting.'],
            ['icon' => 'bi-people', 'title' => 'Learner-to-Learner Protection Concern Protocol', 'desc' => 'Step-by-step protocol for addressing learner-to-learner protection concerns including bullying.'],
            ['icon' => 'bi-house-heart', 'title' => 'Learner-to-Community Concern Protocol', 'desc' => 'Protocol for addressing concerns involving learners and the broader community.'],
            ['icon' => 'bi-heart-pulse', 'title' => 'Panic Attack Classroom Response Guide', 'desc' => 'Immediate classroom response guide for teachers when a student experiences a panic attack.'],
            ['icon' => 'bi-arrow-left-right', 'title' => 'Referral vs Classroom Management Guide', 'desc' => 'A practical guide to help teachers decide when to refer and when to manage in the classroom.'],
            ['icon' => 'bi-briefcase', 'title' => 'Career Landas Toolkits', 'desc' => 'Career guidance toolkits to help students explore pathways and make informed career decisions.'],
        ];
    @endphp

    @if($search || $category)
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search fs-2 d-block mb-2 opacity-50"></i>
            No guides matched your search. <a href="{{ route('teacher.intervention-guides.index') }}">Clear filters</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($placeholders as $p)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;opacity:0.7;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <i class="bi {{ $p['icon'] }} fs-5 mt-1" style="color:#20B2AA;"></i>
                            <h6 class="fw-semibold mb-0">{{ $p['title'] }}</h6>
                        </div>
                        <p class="text-muted small mb-3">{{ $p['desc'] }}</p>
                        <div class="mt-auto pt-2">
                            <span class="badge bg-warning text-dark">Content coming soon</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="alert alert-info mt-4 border-0" style="border-radius:12px;background:rgba(32,178,170,0.08);border-left:4px solid #20B2AA !important;">
            <i class="bi bi-info-circle me-2" style="color:#20B2AA;"></i>
            Intervention guide content will be uploaded by the administrator. Check back soon for downloadable resources.
        </div>
    @endif
@endif
@endsection

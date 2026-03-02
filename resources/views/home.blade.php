@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <p class="mb-0">{{ __('You are logged in!') }}</p>
    </div>
</div>
@endsection

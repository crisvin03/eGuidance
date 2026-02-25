@extends('layouts.dashboard')

@section('title', 'Reports & Analytics')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Concerns by Category</h6>
            </div>
            <div class="card-body">
                @if($concernsByCategory->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($concernsByCategory as $category)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-tag text-primary"></i>
                                                {{ $category->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $category->count }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar bg-primary" style="width: {{ round(($category->count / $concernsByCategory->sum('count')) * 100, 1) }}%"></div>
                                                </div>
                                                <small>{{ round(($category->count / $concernsByCategory->sum('count')) * 100, 1) }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-graph-up" style="font-size: 2rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-2">No data available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Monthly Concerns Trend</h6>
            </div>
            <div class="card-body">
                @if($concernsByMonth->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Concerns</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($concernsByMonth as $month)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $month->count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-calendar3" style="font-size: 2rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-2">No data available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Monthly Appointments Trend</h6>
            </div>
            <div class="card-body">
                @if($appointmentsByMonth->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Appointments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointmentsByMonth as $month)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ $month->count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-calendar-check" style="font-size: 2rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-2">No data available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">System Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <small class="text-muted">Total Concerns</small>
                            <h5 class="mb-0">{{ App\Models\Concern::count() }}</h5>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Resolved Concerns</small>
                            <h5 class="mb-0 text-success">{{ App\Models\Concern::where('status', 'resolved')->count() }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <small class="text-muted">Resolution Rate</small>
                            <h5 class="mb-0 text-primary">{{ App\Models\Concern::count() > 0 ? round((App\Models\Concern::where('status', 'resolved')->count() / App\Models\Concern::count()) * 100, 1) : 0 }}%</h5>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Total Appointments</small>
                            <h5 class="mb-0">{{ App\Models\Appointment::count() }}</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <small class="text-muted">Completed Appointments</small>
                            <h5 class="mb-0 text-success">{{ App\Models\Appointment::where('status', 'completed')->count() }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <small class="text-muted">Completion Rate</small>
                            <h5 class="mb-0 text-primary">{{ App\Models\Appointment::count() > 0 ? round((App\Models\Appointment::where('status', 'completed')->count() / App\Models\Appointment::count()) * 100, 1) : 0 }}%</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h6 class="card-title">Export Options</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-2">
                <a href="{{ route('admin.reports.export.concerns') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-download"></i>
                    Export Concerns (CSV)
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <a href="{{ route('admin.reports.export.appointments') }}" class="btn btn-success w-100">
                    <i class="bi bi-download"></i>
                    Export Appointments (CSV)
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <a href="{{ route('admin.reports.export.users') }}" class="btn btn-info w-100">
                    <i class="bi bi-download"></i>
                    Export Users (CSV)
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <a href="{{ route('admin.reports.export.full') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-file-earmark-text"></i>
                    Generate Full Report
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

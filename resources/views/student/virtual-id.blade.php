@extends('layouts.dashboard')
@section('title', 'Virtual ID')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Virtual Student ID</h5>
    <small class="text-muted">Your digital student identification card</small>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow" style="border-radius:20px;">
            <div class="card-body p-4">
                @if(!Auth::user()->profile_photo || !Auth::user()->lrn || !Auth::user()->grade_level || !Auth::user()->section)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Incomplete Profile:</strong> Please update your profile with all required information (photo, LRN, grade level, section, adviser, contact person, and contact number) to generate a complete virtual ID.
                    <a href="{{ route('profile') }}" class="alert-link">Update Profile</a>
                </div>
                @endif

                <!-- Virtual ID Card -->
                <div id="virtualIdCard" style="background: linear-gradient(135deg, #1a3a3a 0%, #2d5a5a 50%, #20B2AA 100%); border-radius:16px; padding:30px; color:#fff; position:relative; overflow:hidden;">
                    <!-- Background Pattern -->
                    <div style="position:absolute; top:0; left:0; right:0; bottom:0; background-image: radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px); background-size: 20px 20px; opacity:0.5;"></div>
                    
                    <!-- Content -->
                    <div style="position:relative; z-index:2;">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h5 class="fw-bold mb-1" style="letter-spacing:1px;">BULAN NATIONAL HIGH SCHOOL</h5>
                            <small style="opacity:0.9;">Student Identification Card</small>
                        </div>

                        <!-- ID Content -->
                        <div class="row align-items-center">
                            <div class="col-4 text-center">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                         alt="Student Photo" 
                                         style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:3px solid #fff; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                                @else
                                    <div style="width:120px; height:120px; background:rgba(255,255,255,0.2); border-radius:12px; border:3px solid #fff; display:flex; align-items:center; justify-content:center; margin:0 auto; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                                        <i class="bi bi-person-circle" style="font-size:60px;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-8">
                                <div class="mb-3">
                                    <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Full Name</small>
                                    <div class="fw-bold" style="font-size:1.1rem;">{{ Auth::user()->name }}</div>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">LRN</small>
                                        <div class="fw-semibold">{{ Auth::user()->lrn ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Grade & Section</small>
                                        <div class="fw-semibold">{{ Auth::user()->grade_level && Auth::user()->section ? Auth::user()->grade_level . ' - ' . Auth::user()->section : 'N/A' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Adviser</small>
                                        <div class="fw-semibold">{{ Auth::user()->adviser ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,0.3);">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Contact Person</small>
                                    <div class="fw-semibold">{{ Auth::user()->contact_person ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Contact Number</small>
                                    <div class="fw-semibold">{{ Auth::user()->contact_number ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,0.3);">
                            <small style="opacity:0.7; font-size:0.7rem;">Valid for School Year {{ date('Y') }}-{{ date('Y') + 1 }}</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex gap-2 justify-content-center">
                    <button class="btn btn-outline-primary" onclick="downloadVirtualId()">
                        <i class="bi bi-download me-1"></i> Download as Image
                    </button>
                    <button class="btn btn-primary" style="background:#20B2AA; border-color:#20B2AA;" onclick="printVirtualId()">
                        <i class="bi bi-printer me-1"></i> Print ID
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Keep your virtual ID accessible for quick identification within the school.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadVirtualId() {
    const element = document.getElementById('virtualIdCard');
    html2canvas(element, {
        scale: 2,
        backgroundColor: null
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'virtual-id-{{ Auth::user()->student_id ?? "student" }}.png';
        link.href = canvas.toDataURL();
        link.click();
    });
}

function printVirtualId() {
    const element = document.getElementById('virtualIdCard');
    html2canvas(element, {
        scale: 2,
        backgroundColor: null
    }).then(canvas => {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Virtual ID - {{ Auth::user()->name }}</title>
                <style>
                    body { margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
                    img { max-width: 100%; height: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 16px; }
                    @media print { body { padding: 0; } }
                </style>
            </head>
            <body>
                <img src="${canvas.toDataURL()}" alt="Virtual ID">
            </body>
            </html>
        `);
        printWindow.document.close();
        setTimeout(() => printWindow.print(), 500);
    });
}
</script>
@endsection

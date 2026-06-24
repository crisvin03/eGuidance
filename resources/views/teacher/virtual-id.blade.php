@extends('layouts.dashboard')

@section('title', 'Virtual Teacher ID')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
        @if(!Auth::user()->profile_photo || !Auth::user()->phone)
        <div class="alert alert-warning mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Please complete your profile (photo, contact information, and advisee) for a complete virtual ID.
            <a href="{{ route('profile') }}" class="alert-link">Go to Profile</a>
        </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-badge me-2"></i>Virtual Teacher ID
                </h5>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </a>
            </div>
            <div class="card-body">
                <!-- Virtual ID Card -->
                <div id="teacherVirtualIdCard" style="background: linear-gradient(135deg, #1a3a3a 0%, #2d5a5a 50%, #20B2AA 100%); border-radius:16px; padding:30px; color:#fff; position:relative; overflow:hidden;">
                    <!-- Background Pattern -->
                    <div style="position:absolute; top:0; left:0; right:0; bottom:0; background-image: radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px); background-size: 20px 20px; opacity:0.5;"></div>
                    
                    <!-- Content -->
                    <div style="position:relative; z-index:2;">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h5 class="fw-bold mb-1" style="letter-spacing:1px;">BULAN NATIONAL HIGH SCHOOL</h5>
                            <small style="opacity:0.9;">Teacher Identification Card</small>
                        </div>

                        <!-- ID Content -->
                        <div class="row align-items-center">
                            <div class="col-4 text-center">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                         alt="Teacher Photo" 
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
                                    <div class="col-12">
                                        <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Position</small>
                                        <div class="fw-semibold">Teacher</div>
                                    </div>
                                    @if(Auth::user()->advisee)
                                    <div class="col-12">
                                        <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Advisee</small>
                                        <div class="fw-semibold">{{ Auth::user()->advisee }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,0.3);">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Contact Number</small>
                                    <div class="fw-semibold">{{ Auth::user()->phone ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Email</small>
                                    <div class="fw-semibold" style="font-size:0.85rem;">{{ Auth::user()->email }}</div>
                                </div>
                                @if(Auth::user()->address)
                                <div class="col-12">
                                    <small style="opacity:0.8; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Address</small>
                                    <div class="fw-semibold" style="font-size:0.85rem;">{{ Auth::user()->address }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,0.3);">
                            <small style="opacity:0.7; font-size:0.7rem;">Valid for School Year {{ date('Y') }}-{{ date('Y') + 1 }}</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex gap-2 justify-content-center flex-wrap">
                    <button class="btn btn-outline-primary" onclick="downloadTeacherVirtualId()">
                        <i class="bi bi-download me-1"></i> Download as Image
                    </button>
                    <button class="btn btn-primary" style="background:#20B2AA; border-color:#20B2AA;" onclick="printTeacherVirtualId()">
                        <i class="bi bi-printer me-1"></i> Print ID
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadTeacherVirtualId() {
    const element = document.getElementById('teacherVirtualIdCard');
    html2canvas(element, {
        scale: 2,
        backgroundColor: null
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'teacher-id-{{ Auth::user()->name }}.png';
        link.href = canvas.toDataURL();
        link.click();
    });
}

function printTeacherVirtualId() {
    const element = document.getElementById('teacherVirtualIdCard');
    html2canvas(element, {
        scale: 2,
        backgroundColor: null
    }).then(canvas => {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Teacher Virtual ID - {{ Auth::user()->name }}</title>
                <style>
                    body { margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
                    img { max-width: 100%; height: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 16px; }
                    @media print { body { padding: 0; } }
                </style>
            </head>
            <body>
                <img src="${canvas.toDataURL()}" alt="Teacher Virtual ID">
            </body>
            </html>
        `);
        printWindow.document.close();
        setTimeout(() => printWindow.print(), 500);
    });
}
</script>
@endsection

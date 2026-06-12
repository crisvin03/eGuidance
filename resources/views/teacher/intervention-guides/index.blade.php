@extends('layouts.dashboard')
@section('title', 'Intervention Guides')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Intervention Guides</h5>
    <small class="text-muted">Searchable guides, downloadable resources, and online tools for classroom intervention and student support.</small>
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
    <!-- Built-in Intervention Guide Content -->

    @if($search || $category)
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search fs-2 d-block mb-2 opacity-50"></i>
            No guides matched your search. <a href="{{ route('teacher.intervention-guides.index') }}">Clear filters</a>
        </div>
    @else

        <!-- Guide Cards Grid -->
        <div class="row g-3 mb-4">
            @php
                $guideCards = [
                    ['id'=>'adult-learner','icon'=>'bi-shield-exclamation','title'=>'Adult-to-Learner Protection Concern Protocol','desc'=>'Guidelines for handling adult-to-learner protection concerns in the school setting.','color'=>'#dc3545'],
                    ['id'=>'learner-learner','icon'=>'bi-people','title'=>'Learner-to-Learner Protection Concern Protocol','desc'=>'Step-by-step protocol for addressing learner-to-learner protection concerns including bullying.','color'=>'#e67e22'],
                    ['id'=>'learner-community','icon'=>'bi-house-heart','title'=>'Learner-to-Community Concern Protocol','desc'=>'Protocol for addressing concerns involving learners and the broader community.','color'=>'#8e44ad'],
                    ['id'=>'panic-attack','icon'=>'bi-heart-pulse','title'=>'Panic Attack Classroom Response Guide','desc'=>'Immediate classroom response guide for teachers when a student experiences a panic attack.','color'=>'#e74c3c'],
                    ['id'=>'referral-guide','icon'=>'bi-arrow-left-right','title'=>'Referral vs Classroom Management Guide','desc'=>'A practical guide to help teachers decide when to refer and when to manage in the classroom.','color'=>'#2980b9'],
                    ['id'=>'career-landas','icon'=>'bi-briefcase','title'=>'Career Landas Toolkits','desc'=>'Career guidance toolkits to help students explore pathways and make informed career decisions.','color'=>'#27ae60'],
                ];
            @endphp
            @foreach($guideCards as $g)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;cursor:pointer;transition:all .3s;" onclick="openGuideModal('{{ $g['id'] }}')" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px;height:48px;background:{{ $g['color'] }}15;">
                                <i class="bi {{ $g['icon'] }} fs-5" style="color:{{ $g['color'] }};"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $g['title'] }}</h6>
                                <p class="text-muted small mb-0">{{ $g['desc'] }}</p>
                            </div>
                        </div>
                        <div class="mt-auto pt-2">
                            <button type="button" class="btn btn-sm text-white w-100" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                                <i class="bi bi-book me-1"></i>Read Full Guide
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- ═══ Guide Modals ═══ -->

        <!-- 1. Adult-to-Learner Protection -->
        <div class="modal fade" id="modal-adult-learner" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:16px;border:none;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#dc3545,#a71d2a);border-radius:16px 16px 0 0;">
                        <h5 class="modal-title text-white fw-bold"><i class="bi bi-shield-exclamation me-2"></i>Adult-to-Learner Protection Concern Protocol</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#dc3545;"><i class="bi bi-exclamation-triangle me-2"></i>Signs & Indicators</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ul class="small mb-0 ps-3">
                                    <li>Unexplained injuries, bruises, or marks</li>
                                    <li>Sudden changes in behavior or academic performance</li>
                                    <li>Withdrawal from social activities or friendships</li>
                                    <li>Excessive fear of specific adults or places</li>
                                    <li>Inappropriate sexual knowledge for age level</li>
                                    <li>Frequent absences or tardiness without valid reason</li>
                                    <li>Regression in developmental milestones</li>
                                    <li>Reluctance to go home or be alone with certain individuals</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#dc3545;"><i class="bi bi-list-check me-2"></i>Immediate Actions for Teachers</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li><strong>Ensure safety</strong> &mdash; Remove the learner from any immediate danger</li>
                                    <li><strong>Document everything</strong> &mdash; Record date, time, location, observations, and exact words used by the learner</li>
                                    <li><strong>Report immediately</strong> &mdash; Notify the Guidance Counselor and Child Protection Committee (CPC) within 24 hours</li>
                                    <li><strong>Do NOT confront</strong> &mdash; Never confront the alleged abuser directly</li>
                                    <li><strong>Do NOT promise secrecy</strong> &mdash; Explain to the learner that you need to share with people who can help</li>
                                    <li><strong>Preserve evidence</strong> &mdash; Do not wash, clean, or alter anything that may serve as evidence</li>
                                    <li><strong>Provide emotional support</strong> &mdash; Listen without judgment, reassure the learner they did the right thing</li>
                                </ol>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#dc3545;"><i class="bi bi-diagram-2 me-2"></i>Reporting Flowchart</h6>
                            <div class="bg-light rounded-3 p-3 text-center small">
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <span class="badge bg-danger px-3 py-2">Teacher observes/receives disclosure</span>
                                    <i class="bi bi-arrow-right"></i>
                                    <span class="badge bg-warning text-dark px-3 py-2">Document incident</span>
                                    <i class="bi bi-arrow-right"></i>
                                    <span class="badge bg-info text-dark px-3 py-2">Report to Guidance Counselor</span>
                                    <i class="bi bi-arrow-right"></i>
                                    <span class="badge bg-primary px-3 py-2">CPC convenes within 48hrs</span>
                                    <i class="bi bi-arrow-right"></i>
                                    <span class="badge bg-success px-3 py-2">Refer to DSWD / LSWDO</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#dc3545;"><i class="bi bi-file-earmark-text me-2"></i>Legal Framework</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>RA 7610</strong> &mdash; Special Protection of Children Against Abuse, Exploitation & Discrimination Act</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>RA 9344</strong> &mdash; Juvenile Justice and Welfare Act</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>DepEd Order No. 40 s. 2012</strong> &mdash; Child Protection Policy</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>RA 10627</strong> &mdash; Anti-Bullying Act of 2013</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>RA 11313</strong> &mdash; Safe Spaces Act (Bawal Bastos Law)</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>RA 11930</strong> &mdash; Anti-Online Sexual Abuse or Exploitation of Children Act</div></div>
                            </div>
                        </div>
                        <div class="alert alert-danger border-0 rounded-3 small">
                            <i class="bi bi-exclamation-diamond me-2"></i><strong>Mandatory Reporting:</strong> All school personnel are mandated reporters. Failure to report suspected abuse is punishable under Philippine law.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Learner-to-Learner Protection -->
        <div class="modal fade" id="modal-learner-learner" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:16px;border:none;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#e67e22,#d35400);border-radius:16px 16px 0 0;">
                        <h5 class="modal-title text-white fw-bold"><i class="bi bi-people me-2"></i>Learner-to-Learner Protection Concern Protocol</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#e67e22;"><i class="bi bi-eye me-2"></i>Types of Bullying</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong class="text-danger">Physical:</strong> Hitting, pushing, kicking, damaging property, blocking passage</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong class="text-warning">Verbal:</strong> Name-calling, teasing, threats, spreading rumors, sarcasm</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong class="text-info">Social/Relational:</strong> Exclusion, peer pressure, manipulation of friendships, public embarrassment</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong class="text-primary">Cyber:</strong> Online harassment, sharing private info, fake accounts, threatening messages</div></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#e67e22;"><i class="bi bi-diagram-2 me-2"></i>Step-by-Step Intervention</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li><strong>Intervene immediately</strong> &mdash; Stop the behavior on the spot. Say "Stop. That is not acceptable."</li>
                                    <li><strong>Separate the learners</strong> &mdash; Move them to different areas; ensure safety of the victim</li>
                                    <li><strong>Support the victim</strong> &mdash; Ask "Are you okay?" Listen and validate their feelings</li>
                                    <li><strong>Document the incident</strong> &mdash; Fill out the Incident Report Form with details</li>
                                    <li><strong>Notify parents/guardians</strong> &mdash; Contact parents of both the victim and the aggressor</li>
                                    <li><strong>Refer to Guidance Counselor</strong> &mdash; Submit referral for professional assessment and mediation</li>
                                    <li><strong>Implement restorative measures</strong> &mdash; Facilitate dialogue if both parties are willing</li>
                                    <li><strong>Monitor follow-up</strong> &mdash; Check in with the victim weekly for at least 1 month</li>
                                    <li><strong>Escalate if severe</strong> &mdash; Refer to the Discipline Committee for suspension or other sanctions</li>
                                </ol>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#e67e22;"><i class="bi bi-shield-check me-2"></i>Prevention Strategies</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Establish clear anti-bullying classroom rules on Day 1</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Conduct monthly empathy-building activities</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Implement a peer buddy/mentoring system</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Create anonymous reporting channels (suggestion box)</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Hold weekly class meetings on respect & inclusion</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Model respectful behavior at all times</div></div>
                            </div>
                        </div>
                        <div class="alert alert-warning border-0 rounded-3 small">
                            <i class="bi bi-info-circle me-2"></i><strong>RA 10627 (Anti-Bullying Act):</strong> Schools are required to have an Anti-Bullying Policy and a Child Protection Committee. All bullying incidents must be documented and reported.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Learner-to-Community Concern -->
        <div class="modal fade" id="modal-learner-community" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:16px;border:none;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#8e44ad,#6c3483);border-radius:16px 16px 0 0;">
                        <h5 class="modal-title text-white fw-bold"><i class="bi bi-house-heart me-2"></i>Learner-to-Community Concern Protocol</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#8e44ad;"><i class="bi bi-exclamation-circle me-2"></i>Common Community Concerns</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Vandalism and property damage</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Gang activities or fraternity involvement</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Substance use or dealing</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Conflict with community members</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Truancy and loitering during school hours</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Involvement in illegal activities</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Early pregnancy or teenage relationships</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small">Child labor or exploitation</div></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#8e44ad;"><i class="bi bi-arrow-repeat me-2"></i>Response Protocol</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li><strong>Gather information</strong> &mdash; Verify facts from multiple sources before acting</li>
                                    <li><strong>Notify school personnel</strong> &mdash; Inform the Guidance Counselor and Class Adviser</li>
                                    <li><strong>Contact parents/guardians</strong> &mdash; Schedule a meeting to discuss concerns collaboratively</li>
                                    <li><strong>Coordinate with barangay</strong> &mdash; Engage barangay officials for community-based concerns</li>
                                    <li><strong>Develop a behavioral contract</strong> &mdash; Create a written agreement with the learner and parents</li>
                                    <li><strong>Connect with social services</strong> &mdash; Refer to DSWD or LGU social welfare if needed</li>
                                    <li><strong>Provide ongoing counseling</strong> &mdash; Schedule regular check-ins with the Guidance Counselor</li>
                                    <li><strong>Monitor and document</strong> &mdash; Keep records of progress, setbacks, and interventions</li>
                                </ol>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#8e44ad;"><i class="bi bi-people-fill me-2"></i>Community Partner Directory</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>Barangay Council / BCPC</strong> &mdash; Local mediation, peacekeeping, and youth programs</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>DSWD / LSWDO</strong> &mdash; Social welfare, family assessment, and financial assistance</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>PNP Women & Children Desk</strong> &mdash; Legal protection and case filing</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>NGOs (e.g., CFSI, STAIRWAY)</strong> &mdash; Youth development, child protection programs</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>Church/Religious Groups</strong> &mdash; Moral guidance and community mentoring</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><strong>LGU Health Office</strong> &mdash; Substance abuse rehab and mental health referrals</div></div>
                            </div>
                        </div>
                        <div class="alert alert-info border-0 rounded-3 small" style="background:rgba(142,68,173,0.08);">
                            <i class="bi bi-info-circle me-2"></i><strong>Key Law:</strong> RA 9344 (Juvenile Justice & Welfare Act) &mdash; Children in conflict with the law must be handled through diversion programs, not criminal proceedings.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Panic Attack Response Guide -->
        <div class="modal fade" id="modal-panic-attack" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:16px;border:none;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#e74c3c,#c0392b);border-radius:16px 16px 0 0;">
                        <h5 class="modal-title text-white fw-bold"><i class="bi bi-heart-pulse me-2"></i>Panic Attack Classroom Response Guide</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#e74c3c;"><i class="bi bi-search me-2"></i>Recognizing a Panic Attack</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-wind me-2 text-danger"></i>Rapid breathing or hyperventilation</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-heart me-2 text-danger"></i>Racing heartbeat, chest pain</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-droplet me-2 text-danger"></i>Trembling, sweating, hot/cold flashes</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-emoji-dizzy me-2 text-danger"></i>Dizziness or lightheadedness</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-exclamation-diamond me-2 text-danger"></i>Sense of impending doom</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-hand-index me-2 text-danger"></i>Numbness or tingling in hands/feet</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-eye-slash me-2 text-danger"></i>Feeling of losing control</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-2 small"><i class="bi bi-emoji-frown me-2 text-danger"></i>Fear of dying or "going crazy"</div></div>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-hand-thumbs-up me-2"></i>DO's</h6>
                                <div class="bg-light rounded-3 p-3">
                                    <ol class="small mb-0 ps-3">
                                        <li><strong>Stay calm</strong> &mdash; Your calmness is contagious and helps the student</li>
                                        <li><strong>Move to a quiet space</strong> &mdash; Reduce sensory stimulation</li>
                                        <li><strong>Use the 5-4-3-2-1 grounding technique:</strong>
                                            <br>Name 5 things you can see
                                            <br>4 things you can touch
                                            <br>3 things you can hear
                                            <br>2 things you can smell
                                            <br>1 thing you can taste
                                        </li>
                                        <li><strong>Guide box breathing:</strong> "Breathe in for 4, hold for 4, out for 6, hold for 4"</li>
                                        <li><strong>Use reassuring words:</strong> "You are safe. This will pass. I'm here with you."</li>
                                        <li><strong>Stay with them</strong> until the episode passes (usually 10-20 minutes)</li>
                                        <li><strong>Notify the counselor</strong> after the episode for follow-up</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-2 text-danger"><i class="bi bi-x-circle me-2"></i>DON'Ts</h6>
                                <div class="bg-light rounded-3 p-3">
                                    <ul class="small mb-0 ps-3">
                                        <li class="mb-2">Do NOT say "calm down," "relax," or "it's nothing"</li>
                                        <li class="mb-2">Do NOT draw attention from other students</li>
                                        <li class="mb-2">Do NOT leave the student alone</li>
                                        <li class="mb-2">Do NOT force them to talk about what triggered it</li>
                                        <li class="mb-2">Do NOT minimize their feelings or experience</li>
                                        <li class="mb-2">Do NOT assume it's "just acting out" or drama</li>
                                        <li class="mb-2">Do NOT crowd the student or touch them without asking</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#e74c3c;"><i class="bi bi-clipboard-check me-2"></i>After the Episode</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li>Document the incident (date, time, duration, triggers observed)</li>
                                    <li>Inform the parents/guardians with sensitivity</li>
                                    <li>Refer to the Guidance Counselor for assessment and follow-up</li>
                                    <li>Check in with the student the next day and periodically after</li>
                                    <li>Develop a classroom support plan if episodes are recurring</li>
                                </ol>
                            </div>
                        </div>
                        <div class="alert alert-danger border-0 rounded-3 small">
                            <i class="bi bi-telephone me-2"></i><strong>If the student expresses suicidal thoughts:</strong> Stay with them, do not leave, and immediately contact the Guidance Counselor or call the NCMH Crisis Hotline at <strong>0917-899-8727</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Referral vs Classroom Management -->
        <div class="modal fade" id="modal-referral-guide" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:16px;border:none;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#2980b9,#1a5276);border-radius:16px 16px 0 0;">
                        <h5 class="modal-title text-white fw-bold"><i class="bi bi-arrow-left-right me-2"></i>Referral vs Classroom Management Guide</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card border-0 h-100" style="border-radius:12px;border-left:4px solid #27ae60;">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-person-workspace me-2"></i>Manage in the Classroom</h6>
                                        <p class="small text-muted mb-2">Handle these directly with classroom strategies:</p>
                                        <ul class="small mb-3 ps-3">
                                            <li>Occasional tardiness or minor disruptions</li>
                                            <li>Temporary dip in academic performance</li>
                                            <li>Minor peer conflicts that resolve quickly</li>
                                            <li>Occasional inattention or daydreaming</li>
                                            <li>Mild resistance to classwork</li>
                                            <li>First-time minor rule violations</li>
                                            <li>Mild test anxiety or performance nerves</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 h-100" style="border-radius:12px;border-left:4px solid #dc3545;">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-2" style="color:#dc3545;"><i class="bi bi-person-up me-2"></i>Refer to the Guidance Counselor</h6>
                                        <p class="small text-muted mb-2">Escalate for professional support:</p>
                                        <ul class="small mb-3 ps-3">
                                            <li>Suspected abuse, neglect, or exploitation</li>
                                            <li>Signs of depression, anxiety, or self-harm</li>
                                            <li>Repeated aggressive behavior or bullying</li>
                                            <li>Chronic absenteeism despite interventions</li>
                                            <li>Sudden dramatic behavioral changes</li>
                                            <li>Disclosure of suicidal thoughts</li>
                                            <li>Substance use or possession</li>
                                            <li>Family crisis affecting school performance</li>
                                            <li>Eating disorders or body image concerns</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-tools me-2"></i>Classroom Management Strategies</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li><strong>Private conversation</strong> &mdash; Talk one-on-one, not in front of peers</li>
                                    <li><strong>Adjust seating</strong> &mdash; Move the student closer to you or away from distractions</li>
                                    <li><strong>Positive reinforcement</strong> &mdash; Praise good behavior immediately and specifically</li>
                                    <li><strong>Behavior tracking chart</strong> &mdash; Monitor patterns over 2-3 weeks</li>
                                    <li><strong>Check-in system</strong> &mdash; Brief morning check-ins with the student</li>
                                    <li><strong>Cool-down breaks</strong> &mdash; Allow 5-minute breaks when the student seems overwhelmed</li>
                                    <li><strong>Differentiated instruction</strong> &mdash; Provide alternative ways to demonstrate learning</li>
                                    <li><strong>Parent communication</strong> &mdash; Inform parents of patterns and collaborate on solutions</li>
                                </ol>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#dc3545;"><i class="bi bi-file-earmark-plus me-2"></i>How to Make a Referral</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li>Complete the <strong>Student Referral Form</strong> (available in Generate Forms page)</li>
                                    <li>Include specific observations with <strong>dates and times</strong></li>
                                    <li>Describe what classroom strategies you've already tried</li>
                                    <li>Submit to the Guidance Office within <strong>24 hours</strong> of the concerning incident</li>
                                    <li>Follow up with the counselor after <strong>1 week</strong> for status update</li>
                                </ol>
                            </div>
                        </div>
                        <div class="alert alert-info border-0 rounded-3 small" style="background:rgba(41,128,185,0.08);">
                            <i class="bi bi-lightbulb me-2"></i><strong>Rule of Thumb:</strong> If a behavior persists for more than 2 weeks despite your classroom interventions, it's time to refer. You are not expected to be a counselor &mdash; your role is to observe, support, and escalate.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Career Landas Toolkits -->
        <div class="modal fade" id="modal-career-landas" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius:16px;border:none;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#27ae60,#1e8449);border-radius:16px 16px 0 0;">
                        <h5 class="modal-title text-white fw-bold"><i class="bi bi-briefcase me-2"></i>Career Landas Toolkits</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-compass me-2"></i>Career Exploration Activities</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong>Interest Inventory</strong> &mdash; Use RIASEC or Holland Code assessment to identify career interests. Available free at <a href="https://www.mynextmove.org/explore/ip" target="_blank">O*NET Interest Profiler</a></div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong>Career Fair</strong> &mdash; Invite professionals (doctors, engineers, artists, TESDA grads) to share their career journeys</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong>Job Shadowing</strong> &mdash; Arrange workplace visits where students observe professionals in real settings</div></div>
                                <div class="col-md-6"><div class="bg-light rounded-3 p-3 small"><strong>Alumni Panel</strong> &mdash; Former students share their post-graduation experiences and advice</div></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-mortarboard me-2"></i>Senior High School Track Guide</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="bg-light rounded-3 p-3 small">
                                        <strong>Academic Track</strong><br>
                                        <span class="text-muted">STEM &mdash; Science, Technology, Engineering, Math</span><br>
                                        <span class="text-muted">ABM &mdash; Accountancy, Business, Management</span><br>
                                        <span class="text-muted">HUMSS &mdash; Humanities, Social Sciences</span><br>
                                        <span class="text-muted">GAS &mdash; General Academic Strand</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light rounded-3 p-3 small">
                                        <strong>TVL Track</strong><br>
                                        <span class="text-muted">Home Economics (Baking, Cookery, etc.)</span><br>
                                        <span class="text-muted">ICT (Programming, Animation, etc.)</span><br>
                                        <span class="text-muted">Industrial Arts (Welding, Electrical, etc.)</span><br>
                                        <span class="text-muted">Agri-Fishery Arts</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light rounded-3 p-3 small">
                                        <strong>Sports Track</strong><br>
                                        <span class="text-muted">Physical education, coaching, fitness, sports officiating</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light rounded-3 p-3 small">
                                        <strong>Arts & Design Track</strong><br>
                                        <span class="text-muted">Creative arts, media production, performing arts, visual arts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-tools me-2"></i>Practical Classroom Activities</h6>
                            <div class="bg-light rounded-3 p-3">
                                <ol class="small mb-0 ps-3">
                                    <li><strong>Skills Assessment:</strong> Use free tools like 16Personalities or VIA Character Strengths to help students identify their strengths</li>
                                    <li><strong>Goal Setting Workshop:</strong> Have students create SMART 5-year career plans with milestones</li>
                                    <li><strong>Resume Writing:</strong> Teach basic resume, cover letter, and bio-data writing skills</li>
                                    <li><strong>Mock Interviews:</strong> Practice professional communication through role-play scenarios</li>
                                    <li><strong>Scholarship Guide:</strong> Compile a list of CHED, DOST, TESDA, and private scholarships available to graduates</li>
                                    <li><strong>College Application Prep:</strong> Guide students through college entrance exam preparation and application processes</li>
                                </ol>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color:#27ae60;"><i class="bi bi-globe me-2"></i>Free Online Resources</h6>
                            <div class="row g-2">
                                <div class="col-md-6"><a href="https://e-tesda.gov.ph" target="_blank" class="btn btn-sm text-white w-100" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"><i class="bi bi-box-arrow-up-right me-1"></i>TESDA Online Program</a></div>
                                <div class="col-md-6"><a href="https://www.mynextmove.org/explore/ip" target="_blank" class="btn btn-sm text-white w-100" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"><i class="bi bi-box-arrow-up-right me-1"></i>O*NET Career Interest Tool</a></div>
                                <div class="col-md-6"><a href="https://deped.gov.ph/k-to-12/senior-high-school/" target="_blank" class="btn btn-sm text-white w-100" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"><i class="bi bi-box-arrow-up-right me-1"></i>DepEd SHS Guide</a></div>
                                <div class="col-md-6"><a href="https://www.16personalities.com" target="_blank" class="btn btn-sm text-white w-100" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"><i class="bi bi-box-arrow-up-right me-1"></i>16Personalities Free Test</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function openGuideModal(id) {
            var modal = new bootstrap.Modal(document.getElementById('modal-' + id));
            modal.show();
        }
        </script>

    @endif
@endif

<!-- ═══════════════════════════════════════════════════════════════════════ -->
<!-- ONLINE RESOURCES SECTION -->
<!-- ═══════════════════════════════════════════════════════════════════════ -->
<hr class="my-5" style="border-color:rgba(32,178,170,0.2);">

<div class="mb-4">
    <h5 class="fw-bold mb-1"><i class="bi bi-globe2 me-2" style="color:#20B2AA;"></i>Online Resources</h5>
    <small class="text-muted">Curated online resources for guidance counseling, mental health support, and student intervention strategies.</small>
</div>

<!-- DepEd & Government Resources -->
<h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:0.5px;">
    <i class="bi bi-building me-2"></i>DepEd & Government Resources
</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-mortarboard" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">DepEd Learning Portal</h6>
                </div>
                <p class="text-muted small mb-3">Official DepEd portal with training modules, learning resources, and policy guidelines for educators.</p>
                <a href="https://lrmds.deped.gov.ph" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-shield-check" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">DepEd Child Protection Policy</h6>
                </div>
                <p class="text-muted small mb-3">DepEd Order No. 40 s. 2012 - Child Protection Policy and related guidelines for school personnel.</p>
                <a href="https://www.deped.gov.ph/category/issuances/deped-orders/" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-heart-pulse" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">DOH National Mental Health Program</h6>
                </div>
                <p class="text-muted small mb-3">Department of Health resources on mental health awareness, programs, and helplines in the Philippines.</p>
                <a href="https://doh.gov.ph/national-mental-health-program" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Mental Health & Counseling -->
<h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:0.5px;">
    <i class="bi bi-emoji-smile me-2"></i>Mental Health & Counseling
</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-telephone" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">NCMH Crisis Hotline</h6>
                </div>
                <p class="text-muted small mb-3">National Center for Mental Health 24/7 crisis hotline (0917-899-8727) and mental health support services.</p>
                <a href="https://ncmh.gov.ph" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-chat-heart" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">MindNation Philippines</h6>
                </div>
                <p class="text-muted small mb-3">Mental wellness platform offering teletherapy, peer support, and wellness tools for Filipino communities.</p>
                <a href="https://www.mindnation.com" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-journal-medical" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">Philippine Mental Health Association</h6>
                </div>
                <p class="text-muted small mb-3">PMHA provides mental health services, counseling, and educational programs for awareness and prevention.</p>
                <a href="https://www.pmha.org.ph" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Intervention & Behavior Support -->
<h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:0.5px;">
    <i class="bi bi-clipboard2-pulse me-2"></i>Intervention & Behavior Support
</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-diagram-3" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">PBIS World</h6>
                </div>
                <p class="text-muted small mb-3">Positive Behavioral Interventions & Supports - free resources for Tier 1, 2, and 3 interventions in schools.</p>
                <a href="https://www.pbisworld.com" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-lightbulb" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">Intervention Central</h6>
                </div>
                <p class="text-muted small mb-3">Free tools and resources for RTI/MTSS including academic and behavioral intervention strategies for educators.</p>
                <a href="https://www.interventioncentral.org" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-person-check" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">Understood.org</h6>
                </div>
                <p class="text-muted small mb-3">Resources for educators supporting students with learning and thinking differences including ADHD and dyslexia.</p>
                <a href="https://www.understood.org" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Career Guidance & Student Development -->
<h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:0.5px;">
    <i class="bi bi-rocket-takeoff me-2"></i>Career Guidance & Student Development
</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-briefcase" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">TESDA Online Program</h6>
                </div>
                <p class="text-muted small mb-3">Free online courses for technical-vocational education to help students explore career pathways and skills training.</p>
                <a href="https://e-tesda.gov.ph" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-book" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">Coursera for Campus</h6>
                </div>
                <p class="text-muted small mb-3">Free professional development courses and certifications from top universities for career readiness programs.</p>
                <a href="https://www.coursera.org" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-compass" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">O*NET Interest Profiler</h6>
                </div>
                <p class="text-muted small mb-3">Free career interest assessment tool that helps students discover occupations matching their interests and strengths.</p>
                <a href="https://www.mynextmove.org/explore/ip" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Anti-Bullying & Safety -->
<h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:0.5px;">
    <i class="bi bi-shield-lock me-2"></i>Anti-Bullying & Safety
</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-hand-thumbs-up" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">StopBullying.gov</h6>
                </div>
                <p class="text-muted small mb-3">Comprehensive resource on bullying prevention with training modules, classroom activities, and intervention strategies.</p>
                <a href="https://www.stopbullying.gov" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-pc-display" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">Common Sense Education</h6>
                </div>
                <p class="text-muted small mb-3">Digital citizenship resources, cyberbullying prevention lessons, and online safety tools for school use.</p>
                <a href="https://www.commonsense.org/education" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-people-fill" style="color:#20B2AA;"></i>
                    </div>
                    <h6 class="fw-semibold mb-0">KidSmart Philippines</h6>
                </div>
                <p class="text-muted small mb-3">Philippine-based child safety program with resources on online safety, anti-bullying, and responsible digital use.</p>
                <a href="https://www.stairwayfoundation.org" target="_blank" class="btn btn-sm text-white mt-auto" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit Site
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Helpful Hotlines Quick Reference -->
<div class="card border-0 shadow-sm mt-4" style="border-radius:16px;background:linear-gradient(135deg,rgba(32,178,170,0.05),rgba(0,139,139,0.05));">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-telephone-fill me-2" style="color:#20B2AA;"></i>Emergency Hotlines Quick Reference</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-white px-2 py-1" style="background:#20B2AA;">NCMH</span>
                    <span class="small">0917-899-8727 (24/7)</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-white px-2 py-1" style="background:#20B2AA;">DSWD</span>
                    <span class="small">Hotline 163</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-white px-2 py-1" style="background:#20B2AA;">PNP</span>
                    <span class="small">Emergency 911</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-white px-2 py-1" style="background:#20B2AA;">Bantay Bata</span>
                    <span class="small">Hotline 163</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-white px-2 py-1" style="background:#20B2AA;">Hopeline</span>
                    <span class="small">0917-558-4673</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-white px-2 py-1" style="background:#20B2AA;">DOH</span>
                    <span class="small">1555 (Mental Health)</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

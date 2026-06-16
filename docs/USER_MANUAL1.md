# SIGMA eGuidance Portal — User Manual

## Table of Contents
1. [System Overview](#system-overview)
2. [System Architecture](#system-architecture)
3. [Getting Started](#getting-started)
4. [Student Guide](#student-guide)
5. [Teacher Guide](#teacher-guide)
6. [Counselor Guide](#counselor-guide)
7. [Administrator Guide](#administrator-guide)
8. [Common Features](#common-features)
9. [Troubleshooting](#troubleshooting)
10. [FAQ](#faq)

---

## System Overview

The **SIGMA eGuidance Portal** (Guidance & Monitoring Assistance) is a comprehensive web-based guidance and counseling management system designed for **Bulan National High School**. It facilitates seamless communication between students, teachers, counselors, and administrators through a unified digital platform.

### Key Features

| Feature | Description |
|---------|-------------|
| **Concern Submission** | Students submit counseling concerns with file attachments and anonymity options |
| **Appointment Management** | Students and teachers schedule, confirm, and track counseling sessions |
| **Incident Reports** | Teachers report and document school incidents with urgency levels and case tracking |
| **Student Referrals** | Teachers formally refer students to the CARE Center for counseling support |
| **Generate Forms** | Teachers auto-generate and print 7 types of official guidance forms |
| **Intervention Guides** | Teachers access DepEd-compliant intervention protocols with expandable modal content |
| **Case Tracking** | Teachers monitor the status of all submitted incident reports and referrals |
| **Talk to Counselor** | Teachers schedule direct appointments with school counselors |
| **Kamusta Ka** | Students perform a mental health self-check with guided support routing |
| **Real-time Notifications** | Email notifications for appointments, concern responses, and status updates |
| **Profile Management** | Personal profiles with photo upload, settings, and password management |
| **Resource Library** | Students access guidance materials, emergency contacts, and self-help tools |
| **Online Resources** | Teachers access curated DepEd, mental health, and career guidance links |
| **Reports & Export** | Administrators view analytics and export reports as Excel-compatible files |
| **Search & Filter** | All listing pages include search, filtering, and pagination |
| **Responsive Design** | Works seamlessly on desktop, tablet, and mobile devices |

### Supported User Roles

| Role | Description |
|------|-------------|
| **Student** | Submit concerns, manage appointments, access resources, Kamusta Ka self-check |
| **Teacher** | Submit incident reports & referrals, generate forms, access intervention guides, case tracking, talk to counselor |
| **Counselor** | Review concerns, manage appointments, add session notes, review incident reports & referrals |
| **Administrator** | Manage all users, categories, system reports with export functionality |

---

## System Architecture

### Technology Stack

**Backend**
- **Framework**: Laravel 12.x
- **PHP Version**: PHP 8.2+
- **Database**: MySQL 8.0+ / SQLite (development)
- **Authentication**: Laravel's built-in authentication system
- **Cache**: File Cache

**Frontend**
- **Template Engine**: Blade (Laravel)
- **CSS Framework**: Bootstrap 5.x
- **JavaScript**: Vanilla JS
- **Icons**: Bootstrap Icons 1.11+
- **Fonts**: Google Fonts (Instrument Sans)
- **Asset Bundling**: Vite

**Infrastructure**
- **Web Server**: Apache / Nginx / Vercel
- **Operating System**: Linux (Ubuntu 20.04+) or Windows
- **Version Control**: Git (GitHub)

### Database Schema

**Core Tables**

| Table | Purpose |
|-------|---------|
| `users` | All user accounts (students, teachers, counselors, admins) with profile data |
| `roles` | User role definitions (Student, Counselor, Administrator, Teacher) |
| `concerns` | Student-submitted counseling concerns with status workflow |
| `concern_categories` | Categories for organizing concerns |
| `appointments` | Scheduled counseling sessions with status tracking |
| `session_notes` | Counselor notes for completed counseling sessions |
| `notifications` | In-app notification records |
| `audit_logs` | System activity and change tracking |
| `incident_reports` | Teacher-submitted incident reports with case numbers |
| `student_referrals` | Teacher-submitted student referrals to the CARE Center |
| `intervention_guides` | Admin-managed intervention guide content and files |

**Relationships**
- Users → Concerns (as student or counselor)
- Users → Appointments (as student or counselor)
- Users → Incident Reports (as teacher)
- Users → Student Referrals (as teacher)
- Concerns → Concern Categories
- Concerns → Appointments
- Appointments → Session Notes

### Application Architecture

**Controllers**
- `StudentController` — Student-specific operations (concerns, appointments, kamustaka, resources)
- `TeacherController` — Teacher-specific operations (incident reports, referrals, forms, case tracking, intervention guides, talk to counselor)
- `CounselorController` — Counselor-specific operations (concern review, appointments, session notes, incident reports, referrals)
- `AdminController` — Administrator operations (user management, categories, reports with export)
- `ProfileController` — Profile management for all roles
- `SettingsController` — User preference settings
- `ConcernController` — Shared concern operations
- `AppointmentController` — Shared appointment operations

**Middleware**
- `auth` — Authentication verification
- `role` — Role-based access control (student, teacher, counselor, admin)

### Email System

Email notifications are sent for:
- Appointment confirmations and scheduling
- Concern responses from counselors
- New incident report/referral submissions
- Status change notifications

---

## Getting Started

### System Requirements
- Modern web browser (Chrome, Firefox, Safari, Edge)
- Stable internet connection
- Valid email address for notifications

### First-Time Login
1. Navigate to the SIGMA eGuidance Portal URL
2. Click **"Register"** if you're a new user
3. Fill in the registration form:
   - Full Name
   - Email Address
   - Student ID (for students)
   - Password (minimum 8 characters)
4. Click **"Create Account"**
5. Log in with your credentials

### Password Recovery
1. Click **"Forgot Password?"** on the login page
2. Enter your registered email address
3. Follow the email instructions to reset your password

---

## Student Guide

### Navigation Menu
- Dashboard
- Submit Concern
- My Concerns
- Appointments
- Resources
- Kamusta Ka?

### Dashboard Overview
- **Quick Stats**: Active concerns count, upcoming appointments, total concerns
- **Recent Activity**: Latest concerns and appointment statuses
- **Quick Actions**: Direct links to submit concerns and book appointments

### Submitting a Concern
1. Navigate to **Submit Concern** in the sidebar
2. Fill in the required information:
   - **Category**: Select from available concern categories
   - **Title**: Brief summary of your concern
   - **Description**: Detailed explanation
   - **Anonymous**: Check to hide your identity from counselors
   - **Attachment**: Upload documents (images, PDFs, up to 5MB)
3. Click **"Submit Concern"**
4. Track status from the **My Concerns** page

### Viewing & Managing Concerns
1. Go to **My Concerns** in the sidebar
2. Use the **search bar** to find concerns by title or description
3. Filter by **status** (submitted, under review, scheduled, resolved) or **category**
4. Click **"View"** to see full details:
   - Submission date, category, and current status
   - Counselor response and scheduled counseling date
   - Uploaded attachments

### Managing Appointments
1. Navigate to **Appointments** in the sidebar
2. **Search** by counselor name, **filter** by status (scheduled, confirmed, completed, cancelled)
3. Click **"View"** for appointment details:
   - Counselor information, date, time, related concern
   - Session notes (after completed appointments)
4. **Reschedule** or **Cancel** appointments as needed
5. You'll receive email confirmation of any changes

### Creating a New Appointment
1. Go to **Appointments → Create Appointment**
2. Select a counselor from the dropdown
3. Choose a preferred date and time
4. Add optional notes about what you'd like to discuss
5. Click **"Schedule Appointment"**

### Kamusta Ka (Mental Health Self-Check)
1. Navigate to **Kamusta Ka?** in the sidebar
2. Select how you're feeling:
   - **I'm Okay** → Redirected to Resources page with wellness materials
   - **Not Sure** → Redirected to book a counseling appointment
   - **I'm Not Okay** → Redirected to a dedicated support page with:
     - Emergency hotline numbers
     - Immediate coping strategies
     - Direct link to schedule urgent counseling
3. This is a private self-assessment — no records are stored

### Accessing Resources
1. Navigate to **Resources** in the sidebar
2. Browse sections:
   - **Emergency Contacts**: Crisis hotlines and immediate help numbers
   - **Guidance Articles**: Self-help materials and mental health tips
   - **Self-Help Tools**: Interactive wellness resources

---

## Teacher Guide

### Navigation Menu
- Dashboard
- Submit Incident Report
- Refer a Student
- Generate Forms
- View Submitted Cases (Case Tracking)
- Intervention Guides
- Talk to Counselor

### Dashboard Overview
- **Stats Cards**: Total incident reports, pending reports, total referrals, pending referrals
- **Recent Reports**: Last 5 submitted incident reports with status badges
- **Recent Referrals**: Last 5 submitted referrals with status badges

### Submitting an Incident Report
1. Navigate to **Submit Incident Report** in the sidebar
2. Fill in the comprehensive report form:
   - **Student Name** and **Grade & Section**
   - **Date of Referral**
   - **Incident Category**: Bullying, Behavioral Concern, Mental Health, Academic Risk, Child Protection, or Classroom Incident
   - **Concern Type**: Academic, Emotional/Mental, Social/Peer, Family, Behavioral, Relationships, Safety/Protection, Career/Future, Counseling Support, or Other
   - **Incident Description**: Detailed account of what happened
   - **Initial Intervention**: Actions you've already taken
   - **Parent/Guardian Info**: Name and contact number (if applicable)
   - **Referred By**: Your name and designation
   - **Urgency Level**: Low, Moderate, or High
   - **Attachment**: Supporting documents (optional, up to 2MB)
3. Click **"Submit Report"**
4. A unique **case number** (e.g., IR-2026-0001) is auto-generated
5. The CARE Center is automatically notified

### Viewing Incident Reports
1. Navigate to **Incident Reports** in the sidebar (shows your reports only)
2. **Search** by case number, student name, or grade/section
3. **Filter** by status (pending, ongoing, closed) and urgency level (low, moderate, high)
4. Click **"View"** for full report details and counselor notes
5. Pagination shows 15 reports per page

### Referring a Student
1. Navigate to **Refer a Student** in the sidebar
2. Fill in the referral form:
   - **Student Name** and **Grade & Section**
   - **Reason for Referral**: Detailed explanation of why the student needs support
   - **Observed Behavior**: Patterns you've noticed (optional)
   - **Actions Already Taken**: What you've done so far (optional)
   - **Preferred Follow-up**: Your recommendation for next steps
   - **Additional Notes**: Any other relevant information
3. Click **"Submit Referral"**
4. A unique **referral number** (e.g., SR-2026-0001) is auto-generated

### Viewing Referrals
1. Navigate to **Referrals** in the sidebar
2. **Search** by referral number, student name, or grade/section
3. **Filter** by status (pending, ongoing, closed)
4. Click **"View"** for full referral details and counselor response

### Generate Forms
1. Navigate to **Generate Forms** in the sidebar
2. Select from 7 official form templates:
   - **Confiscation Slip**: Document confiscated student items
   - **Call Slip**: Summon a student/parent to the guidance office
   - **Risk Assessment Form**: Evaluate student risk level
   - **Bag Search Plan**: Plan and document bag inspections
   - **Good Moral Request Form**: Character assessment request (landscape format)
   - **Home Visitation Form**: Record home visit observations (landscape format)
   - **Conference/Meeting Form**: Document parent-teacher conferences
3. Fill in the required fields for each form template
4. Click **"Generate & Print"** — a print-ready preview opens in a new tab
5. Print directly or save as PDF from the browser

### Case Tracking (View Submitted Cases)
1. Navigate to **View Submitted Cases** in the sidebar
2. This page shows **both** your incident reports and referrals in a unified view
3. **Search** across all cases by case number or student name
4. **Filter** by status to find specific case types
5. Each case shows:
   - Case/referral number
   - Student name and grade/section
   - Current status with color-coded badges
   - Submission date
6. Click **"View"** to see full details of any case

### Intervention Guides
1. Navigate to **Intervention Guides** in the sidebar
2. Browse **6 comprehensive intervention protocol guides**:
   - **Adult-to-Learner Protection Concern Protocol** — RA 7610, RA 9344, DepEd Order No. 40 compliance
   - **Learner-to-Learner Protection Concern Protocol** — Anti-Bullying Act (RA 10627), 9-step intervention
   - **Learner-to-Community Concern Protocol** — 8-step community response, partner directory
   - **Panic Attack Classroom Response Guide** — Recognition signs, DOs/DON'Ts, crisis protocol
   - **Referral vs Classroom Management Guide** — Side-by-side comparison, 5-step referral process
   - **Career Landas Toolkits** — SHS track guide, TESDA/O*NET integration
3. **Search** guides by title or description
4. **Filter** by category
5. Click **"Read Full Guide"** on any card to open a detailed modal with complete protocols
6. **Online Resources Section**: Access curated links organized into 5 categories:
   - DepEd/Government Resources
   - Mental Health Resources
   - Intervention Support
   - Career Guidance
   - Anti-Bullying/Safety
7. **Emergency Hotlines** quick reference card is always visible

### Talk to Counselor
1. Navigate to **Talk to Counselor** in the sidebar
2. **Select a counselor** from the available counselors list
3. **Choose a date and time** for your appointment
4. Add optional **notes** about what you'd like to discuss
5. Click **"Schedule Appointment"**
6. View all your scheduled appointments below the form
7. See appointment status (scheduled, confirmed, completed, cancelled)

---

## Counselor Guide

### Navigation Menu
- Dashboard
- Student Concerns
- Appointments
- Incident Reports
- Student Referrals

### Dashboard Overview
- **Pending Concerns**: Count of concerns awaiting review (shown with badge on sidebar)
- **Today's Appointments**: Sessions scheduled for today
- **Upcoming Appointments**: Next 5 scheduled sessions
- **Pending Incident Reports**: Reports awaiting review (badge on sidebar)
- **Pending Referrals**: Referrals awaiting review (badge on sidebar)

### Managing Student Concerns
1. Navigate to **Student Concerns** in the sidebar
2. **Search** by student name, concern title, or description
3. **Filter** by status (submitted, under review, scheduled, resolved) and category
4. Click **"View"** to see full details:
   - Student information (unless anonymous)
   - Concern details and file attachments
   - Submission history and category

### Responding to Concerns
1. Open a concern from the list
2. Review all provided information and attachments
3. Click **"Respond to Concern"** (available for concerns in "submitted" status)
4. Fill in the response form:
   - **Counseling Date & Time**: Schedule the session
   - **Response**: Your written response to the student
5. Click **"Submit Response"**
6. An appointment is **automatically created** and the student is notified via email
7. The concern status changes to "scheduled"

### Managing Appointments
1. Go to **Appointments** in the sidebar
2. **Search** by student name, **filter** by status
3. Use the status action buttons:
   - **Confirm**: Confirm a scheduled appointment
   - **Complete**: Mark appointment as finished (enables session notes)
   - **Cancel**: Cancel with a reason
4. Click **"View"** for full appointment details

### Appointment Workflow
1. **Scheduled** → Initial status after concern response or direct booking
2. **Confirmed** → Counselor confirms the appointment
3. **Completed** → After the counseling session takes place
4. **Cancelled** → If the appointment is cancelled

### Adding Session Notes
1. Open a **completed** appointment
2. Click **"Add Session Note"**
3. Fill in session details:
   - **Session Type**: Initial, follow-up, crisis, or group
   - **Notes**: Detailed session documentation
   - **Recommendations**: Follow-up actions and referrals
   - **Confidential**: Mark as sensitive to restrict visibility
4. Click **"Save Note"**

### Reviewing Incident Reports
1. Navigate to **Incident Reports** in the sidebar
2. **Search** by case number, student name, or grade/section
3. **Filter** by status (pending, ongoing, closed) and urgency level
4. Click **"View"** to see full incident report details
5. **Update status**: Change from pending → ongoing → closed
6. Add **counselor notes** documenting your intervention and follow-up

### Reviewing Student Referrals
1. Navigate to **Student Referrals** in the sidebar
2. **Search** by referral number, student name, or grade/section
3. **Filter** by status (pending, ongoing, closed)
4. Click **"View"** to see full referral details
5. **Update status** and add **counselor notes** as you work on the case

---

## Administrator Guide

### Navigation Menu
- Dashboard
- User Management
- Categories
- Reports

### Dashboard Overview
- **System Stats**: Total users, students, counselors, total concerns, pending concerns, resolved concerns, total appointments, today's appointments
- **Quick Overview**: At-a-glance view of the entire system's activity

### User Management
1. Navigate to **User Management** in the sidebar
2. **Search** by name, email, or student ID
3. **Filter** by role (Student, Counselor, Admin, Teacher) and status (Active, Inactive)
4. Click **"Add New User"** to create accounts with:
   - Full Name, Email, Password
   - Role assignment (Student, Counselor, Administrator, Teacher)
   - Student ID (for students)
   - Phone, Date of Birth, Gender, Address
5. **Edit** users: Update information, change roles, reset passwords
6. **Activate/Deactivate** users: Toggle account access without deleting

### Managing Categories
1. Navigate to **Categories** in the sidebar
2. View all existing concern categories
3. **Create** new categories with a name and description
4. **Edit** categories: Update name, description, and active status
5. Categories are used by students when submitting concerns

### Reports & Analytics
1. Navigate to **Reports** in the sidebar
2. View comprehensive analytics:
   - **Concerns by Category**: Breakdown with counts and percentages
   - **Monthly Concerns**: Last 12 months trend data
   - **Monthly Appointments**: Last 12 months scheduling data
   - **Appointment Status Breakdown**: Scheduled, confirmed, completed, cancelled counts
3. **Export Reports** — Download Excel-compatible (.xls) files:
   - **Concerns Report**: All concerns with student, category, status, dates
   - **Appointments Report**: All appointments with student, counselor, status, source
   - **Users Report**: All user accounts with role, status, contact info
   - **Full System Report**: Comprehensive report with summary metrics, category breakdown, monthly trends, and appointment analytics

---

## Common Features

### Search, Filter & Pagination
All listing pages across the system include:
- **Search Bar**: Find records by name, title, ID number, or description
- **Filter Dropdowns**: Narrow results by status, category, role, urgency, etc.
- **Pagination**: Navigate through results (15 items per page)
- **Result Count**: Shows "Showing X to Y of Z results"
- Filters and search parameters are preserved in pagination links

### Navigation
- **Sidebar Menu**: Role-specific navigation with active state indicators
- **Top Header**: Page title, user profile dropdown with logout
- **Mobile Responsive**: Hamburger menu toggle on smaller screens, sidebar overlay
- **Badge Indicators**: Unread counts on key navigation items (pending concerns, reports, referrals)

### Notifications
- **Email Notifications**: Automatic emails for:
  - Concern submissions and responses
  - Appointment confirmations and scheduling
  - Status changes and updates
- **In-App Badges**: Sidebar badges show pending counts for counselors

### File Attachments
- **Supported Formats**: Images (JPG, PNG, GIF), Documents (PDF, DOC, DOCX)
- **Size Limit**: Up to 5MB for concerns, 2MB for incident reports
- **Security**: Files stored securely with validated types
- **Download**: View/download attachments from detail pages

### Profile Management (All Roles)
1. Click your profile picture/name in the top-right corner
2. Select **"Profile"** to update:
   - Personal details (name, email, phone)
   - Profile photo (upload/remove)
3. **Change Password**: Update your password with current password verification

### Settings (All Roles)
1. Click your profile in the top-right corner → **"Settings"**
2. Configure:
   - **Notification Preferences**: Email notification toggles
   - **Privacy Settings**: Control data visibility
   - **Counseling Preferences**: Counseling-related settings

---

## Troubleshooting

### Common Issues

**Login Problems**
- Use **"Forgot Password"** to reset your password
- Clear browser cache and cookies
- Try a different browser (Chrome, Firefox, Edge, Safari)
- Contact the administrator if your account is deactivated

**Email Not Received**
- Check spam/junk folders
- Verify your email address is correct in your profile
- Contact the administrator if the issue persists

**File Upload Issues**
- Ensure the file is under the size limit (5MB for concerns, 2MB for reports)
- Check that the file format is supported (JPG, PNG, PDF, DOC, DOCX)
- Ensure a stable internet connection during upload

**Appointment Issues**
- Check for date/time conflicts with existing appointments
- Appointments must be scheduled for future dates only
- Refresh the page if the appointment list doesn't update

**Pagination Not Showing**
- Refresh the page to reload the data
- Ensure your browser is up to date
- Clear browser cache if tables appear blank

**Form Printing Issues**
- Ensure your browser's pop-up blocker allows new windows
- Use the browser's print dialog to select the correct printer
- For landscape forms (Good Moral, Home Visitation), the print layout auto-adjusts

### Performance Tips
- Use a modern, up-to-date browser
- Ensure a stable internet connection
- Close unnecessary browser tabs
- Regularly clear browser cache

---

## FAQ

### General Questions

**Q: How do I reset my password?**
A: Click "Forgot Password?" on the login page and follow the email instructions.

**Q: Will I receive email notifications?**
A: Yes, you'll receive emails for appointment confirmations, concern responses, and important updates.

**Q: Can I change my role?**
A: No, only administrators can change user roles. Contact your admin.

**Q: How do I update my profile?**
A: Click your name/photo in the top-right corner → "Profile" to update your information.

### Student Questions

**Q: Can I submit concerns anonymously?**
A: Yes, check the "Anonymous" option when submitting a concern.

**Q: How long does it take to get a response?**
A: Counselors typically respond within 1-2 business days.

**Q: Can I reschedule my appointment?**
A: Yes, use the "Reschedule" button on your Appointments page.

**Q: Are my concerns confidential?**
A: Yes, all concerns are confidential and only visible to assigned counselors.

**Q: What is Kamusta Ka?**
A: A private mental health self-check that guides you to the right support based on how you're feeling.

### Teacher Questions

**Q: How do I report an incident?**
A: Navigate to "Submit Incident Report" in the sidebar, fill in all required fields, and submit. A case number is auto-generated.

**Q: How do I refer a student for counseling?**
A: Navigate to "Refer a Student" and complete the referral form. A referral number is auto-generated.

**Q: What forms can I generate?**
A: 7 official forms: Confiscation Slip, Call Slip, Risk Assessment, Bag Search Plan, Good Moral Request, Home Visitation Form, and Conference/Meeting Form.

**Q: How do I track my submitted cases?**
A: Navigate to "View Submitted Cases" to see all your incident reports and referrals in one place with current statuses.

**Q: What are Intervention Guides?**
A: 6 comprehensive protocol guides covering adult-to-learner protection, learner-to-learner protection, community concerns, panic attacks, referrals vs classroom management, and career guidance. Each guide can be opened in a detailed modal.

**Q: Can I schedule an appointment with a counselor?**
A: Yes, use the "Talk to Counselor" page to schedule appointments directly.

### Counselor Questions

**Q: How do I respond to a student concern?**
A: Open the concern from "Student Concerns", click "Respond to Concern", set a counseling date, and write your response.

**Q: How do I add session notes?**
A: After completing an appointment, click "Add Session Note" to document the session.

**Q: Can I review teacher-submitted incident reports?**
A: Yes, navigate to "Incident Reports" to view, update status, and add counselor notes.

**Q: How do I process student referrals?**
A: Navigate to "Student Referrals", review the referral details, update the status, and add your notes.

### Administrator Questions

**Q: How do I create a new teacher account?**
A: Go to "User Management" → "Add New User" → select "Teacher" as the role.

**Q: How do I export reports?**
A: Navigate to "Reports" and click the export buttons to download Concerns, Appointments, Users, or Full System reports as Excel files.

**Q: Can I deactivate a user without deleting them?**
A: Yes, use the "Deactivate" button on the user's row. Their data is preserved and can be reactivated.

---

## Contact Support

For technical support or questions:
- **Email**: support@eguidance.portal
- **Help Desk**: Available Monday-Friday, 8:00 AM - 5:00 PM

For urgent counseling matters:
- **Emergency Hotline**: Contact the school guidance office directly
- **On-Call Counselor**: Available through the Talk to Counselor feature

---

## Version Information

**Current Version**: 2.0.0
**Last Updated**: June 2026
**System Name**: SIGMA eGuidance Portal — Guidance & Monitoring Assistance
**School**: Bulan National High School

---

*This manual reflects the current state of the SIGMA eGuidance Portal. Contact your system administrator for any questions or feature requests.*

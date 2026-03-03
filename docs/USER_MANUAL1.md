# eGuidance Portal - User Manual

## Table of Contents
1. [System Overview](#system-overview)
2. [System Architecture](#system-architecture)
   - [System Goals](#system-goals)
   - [Technology Stack](#technology-stack)
   - [System Components](#system-components)
   - [Database Schema](#database-schema)
   - [Application Architecture](#application-architecture)
   - [Security Architecture](#security-architecture)
   - [Email System](#email-system)
   - [File Storage](#file-storage)
   - [Deployment Architecture](#deployment-architecture)
   - [API Documentation](#api-documentation)
   - [Performance Considerations](#performance-considerations)
   - [Scalability](#scalability)
3. [Getting Started](#getting-started)
4. [Student Guide](#student-guide)
5. [Counselor Guide](#counselor-guide)
6. [Administrator Guide](#administrator-guide)
7. [Common Features](#common-features)
8. [Troubleshooting](#troubleshooting)
9. [FAQ](#faq)

---

## System Overview

The eGuidance Portal is a comprehensive web-based guidance and counseling management system designed to facilitate seamless communication between students and counselors. The system provides a platform for submitting concerns, scheduling appointments, tracking progress, and accessing resources.

### Key Features
- **Concern Submission**: Students can submit counseling concerns with file attachments
- **Appointment Management**: Schedule, confirm, and track counseling sessions
- **Real-time Notifications**: Email notifications for important updates
- **Profile Management**: Personal profiles with photo upload capability
- **Resource Library**: Access to guidance materials and self-help tools
- **Responsive Design**: Works seamlessly on desktop and mobile devices

### System Architecture

The eGuidance Portal is a web-based counseling management system built on the Laravel framework. It follows a Model-View-Controller (MVC) architecture pattern with a focus on security, scalability, and maintainability.

#### System Goals
- **Security**: Protect sensitive student and counseling data
- **Usability**: Intuitive interface for students and counselors
- **Scalability**: Handle growing user base and data volume
- **Reliability**: Ensure high availability and data integrity
- **Maintainability**: Clean, documented code for easy maintenance

#### Technology Stack

**Backend**
- **Framework**: Laravel 10.x
- **PHP Version**: PHP 8.2+
- **Database**: MySQL 8.0+ / MariaDB 10.5+
- **Authentication**: Laravel's built-in authentication system
- **Queue System**: Laravel Queues (Redis/Database)
- **Cache**: Redis / File Cache

**Frontend**
- **Template Engine**: Blade (Laravel)
- **CSS Framework**: Bootstrap 5.x
- **JavaScript**: Vanilla JS + Alpine.js (if needed)
- **Icons**: Bootstrap Icons
- **Fonts**: Google Fonts (Instrument Sans)

**Development Tools**
- **Package Manager**: Composer
- **Asset Bundling**: Vite
- **Version Control**: Git
- **Testing**: PHPUnit
- **Code Quality**: PHP CS Fixer, Laravel Pint

**Infrastructure**
- **Web Server**: Apache / Nginx
- **Operating System**: Linux (Ubuntu 20.04+ recommended)
- **Containerization**: Docker (optional)
- **Monitoring**: Laravel Telescope / Custom monitoring

#### System Components

**Core Modules**

**1. Authentication Module**
- User registration and login
- Role-based access control (RBAC)
- Password reset functionality
- Session management
- Profile management

**2. Concern Management Module**
- Concern submission and tracking
- File attachment handling
- Anonymous concern support
- Category-based organization
- Status workflow management

**3. Appointment Module**
- Appointment scheduling
- Calendar integration
- Status tracking (scheduled, confirmed, completed, cancelled)
- Conflict detection
- Reminder system

**4. Communication Module**
- Email notifications
- In-app messaging
- Counselor responses
- System announcements

**5. Resource Module**
- Document library
- Self-help tools
- Emergency contacts
- Educational materials

**6. Reporting Module**
- Usage analytics
- Performance metrics
- User activity logs
- Export functionality

**Supporting Services**

**Email Service**
- SMTP configuration
- Template management
- Queue processing
- Delivery tracking

**File Storage Service**
- Local/Cloud storage
- File validation
- Security scanning
- Access control

**Notification Service**
- Real-time notifications
- Email integration
- Push notifications (future)
- Preference management

#### Database Schema

**Core Tables**

**Users Table**
- id (Primary)
- name (String, 255)
- email (String, 255, Unique)
- email_verified_at (Timestamp)
- password (String, 255)
- role_id (Foreign Key)
- student_id (String, 255, Nullable)
- phone (String, 20, Nullable)
- date_of_birth (Date, Nullable)
- gender (Enum: male, female, other, Nullable)
- address (Text, Nullable)
- profile_photo (String, 255, Nullable)
- is_active (Boolean, Default: true)
- settings (JSON, Nullable)
- remember_token (String, 100)
- created_at, updated_at (Timestamps)

**Roles Table**
- id (Primary)
- name (String, 50, Unique)
- description (Text, Nullable)
- created_at, updated_at (Timestamps)

**Concerns Table**
- id (Primary)
- student_id (Foreign Key)
- category_id (Foreign Key)
- title (String, 255)
- description (Text)
- status (Enum: pending, under_review, scheduled, resolved)
- is_anonymous (Boolean, Default: false)
- counselor_id (Foreign Key, Nullable)
- counselor_response (Text, Nullable)
- counseling_date (DateTime, Nullable)
- resolved_at (DateTime, Nullable)
- attachment_path (String, 255, Nullable)
- attachment_name (String, 255, Nullable)
- created_at, updated_at (Timestamps)

**Appointments Table**
- id (Primary)
- student_id (Foreign Key)
- counselor_id (Foreign Key)
- concern_id (Foreign Key, Nullable)
- appointment_date (DateTime)
- status (Enum: scheduled, confirmed, completed, cancelled)
- notes (Text, Nullable)
- cancellation_reason (Text, Nullable)
- created_at, updated_at (Timestamps)

**Categories Table**
- id (Primary)
- name (String, 100, Unique)
- description (Text, Nullable)
- is_active (Boolean, Default: true)
- created_at, updated_at (Timestamps)

**Session_Notes Table**
- id (Primary)
- appointment_id (Foreign Key)
- counselor_id (Foreign Key)
- session_type (Enum: initial, follow_up, crisis, group)
- notes (Text)
- recommendations (Text, Nullable)
- is_confidential (Boolean, Default: true)
- created_at, updated_at (Timestamps)

**Relationships**
- **Users** hasMany **Concerns** (as student)
- **Users** hasMany **Concerns** (as counselor)
- **Users** hasMany **Appointments** (as student)
- **Users** hasMany **Appointments** (as counselor)
- **Concerns** belongsTo **Categories**
- **Concerns** hasOne **Appointment**
- **Appointments** hasMany **Session_Notes**
- **Users** belongsTo **Roles**

#### Application Architecture

**MVC Pattern Implementation**

**Models**
- **User**: Authentication and profile management
- **Concern**: Concern submission and workflow
- **Appointment**: Scheduling and status management
- **Category**: Concern categorization
- **SessionNote**: Counseling session records
- **Role**: Role-based access control

**Controllers**
- **AuthController**: Authentication operations
- **StudentController**: Student-specific operations
- **CounselorController**: Counselor-specific operations
- **ProfileController**: Profile management
- **SettingsController**: User preferences
- **ConcernController**: Concern CRUD operations
- **AppointmentController**: Appointment management

**Views**
- **Dashboard**: Main dashboard for all roles
- **Concerns**: Concern submission and listing
- **Appointments**: Appointment management
- **Profile**: User profile management
- **Emails**: Notification templates
- **Auth**: Authentication pages

**Middleware Stack**
1. **Web Middleware**: Session state, CSRF protection
2. **Auth Middleware**: Authentication verification
3. **Role Middleware**: Role-based access control
4. **Custom Middleware**: Additional security and logging

**Service Layer**
- **EmailService**: Email notification management
- **FileService**: File upload and storage
- **NotificationService**: Real-time notifications
- **ReportService**: Analytics and reporting

#### Security Architecture

**Authentication & Authorization**
- **Password Hashing**: bcrypt with automatic rehashing
- **Session Management**: Secure session configuration
- **Remember Me**: Secure token-based persistence
- **Rate Limiting**: Login attempt limiting
- **Two-Factor Authentication**: Ready for implementation

**Data Protection**
- **Encryption**: Sensitive data encryption at rest
- **Input Validation**: Comprehensive input sanitization
- **SQL Injection Prevention**: Eloquent ORM with parameter binding
- **XSS Protection**: Output escaping and CSP headers
- **CSRF Protection**: Token-based CSRF prevention

**Access Control**
- **Role-Based Access Control (RBAC)**: Three-tier system
- **Permission Checks**: Method-level authorization
- **Resource Ownership**: User can only access their data
- **Anonymous Support**: Protected anonymous concern submission

**Audit & Logging**
- **Activity Logging**: User action tracking
- **Error Logging**: Comprehensive error tracking
- **Security Events**: Failed login attempts, suspicious activities
- **Data Integrity**: Change tracking for sensitive data

#### Email System

**Architecture**
- **Queue-Based Processing**: Asynchronous email sending
- **Template System**: Dynamic email templates
- **Multi-Transport Support**: SMTP, Mailgun, SendGrid, etc.
- **Delivery Tracking**: Email delivery status monitoring

**Email Types**
1. **Welcome Emails**: New user registration
2. **Password Reset**: Secure password recovery
3. **Concern Notifications**: New concern submissions
4. **Appointment Confirmations**: Scheduled appointments
5. **Status Updates**: Concern/appointment status changes
6. **System Notifications**: Important system updates

**Template System**
- **Blade Templates**: Dynamic content rendering
- **Responsive Design**: Mobile-friendly emails
- **Professional Branding**: Consistent SIGMA branding
- **Personalization**: User-specific content

#### File Storage

**Storage Architecture**
- **Local Storage**: Default file system storage
- **Cloud Storage**: Ready for AWS S3, Google Cloud integration
- **Symbolic Links**: Public access management
- **Access Control**: Secure file access permissions

**File Handling**
- **Upload Validation**: File type, size, and content validation
- **Security Scanning**: Malware detection capabilities
- **Thumbnail Generation**: Automatic image thumbnails
- **Version Control**: File version tracking (future)

**Supported Formats**
- **Images**: JPG, JPEG, PNG, GIF, WebP (max 2MB)
- **Documents**: PDF, DOC, DOCX, TXT (max 2MB)
- **Future**: Audio, Video formats (planned)

#### Deployment Architecture

**Production Environment**
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Load Balancer │────│   Web Server    │────│   Database      │
│   (Nginx/Apache)│    │   (PHP-FPM)     │    │   (MySQL)       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         │                       │                       │
         │              ┌─────────────────┐              │
         │              │   Redis Cache   │              │
         │              │   (Sessions)    │              │
         │              └─────────────────┘              │
         │                       │                       │
         │              ┌─────────────────┐              │
         │              │   File Storage  │              │
         │              │   (Local/S3)    │              │
         │              └─────────────────┘              │
         └───────────────────────────────────────────────┘
```

**Environment Configuration**
- **Development**: Local development with SQLite
- **Staging**: Production-like environment for testing
- **Production**: Full production stack with monitoring

**Deployment Process**
1. **Code Deployment**: Git-based deployment
2. **Dependency Installation**: Composer install
3. **Database Migrations**: Automated schema updates
4. **Asset Building**: Vite build process
5. **Cache Clearing**: Application cache refresh
6. **Health Checks**: Post-deployment verification

#### API Documentation

**RESTful API Endpoints**

**Authentication**
```
POST /api/login          - User authentication
POST /api/logout         - User logout
POST /api/register       - User registration
POST /api/password/email - Password reset request
```

**Concerns**
```
GET    /api/concerns           - List concerns
POST   /api/concerns           - Create concern
GET    /api/concerns/{id}      - Get concern details
PUT    /api/concerns/{id}      - Update concern
DELETE /api/concerns/{id}      - Delete concern
POST   /api/concerns/{id}/respond - Respond to concern
```

**Appointments**
```
GET    /api/appointments           - List appointments
POST   /api/appointments           - Create appointment
GET    /api/appointments/{id}      - Get appointment details
PUT    /api/appointments/{id}      - Update appointment
DELETE /api/appointments/{id}      - Delete appointment
POST   /api/appointments/{id}/respond - Respond to appointment
```

**Users**
```
GET    /api/users/profile         - Get user profile
PUT    /api/users/profile         - Update profile
POST   /api/users/profile/photo   - Upload profile photo
DELETE /api/users/profile/photo   - Remove profile photo
```

**Response Format**
```json
{
    "success": true,
    "data": { ... },
    "message": "Operation successful",
    "errors": null
}
```

**Error Handling**
- **400**: Bad Request (validation errors)
- **401**: Unauthorized (authentication required)
- **403**: Forbidden (insufficient permissions)
- **404**: Not Found (resource not found)
- **422**: Unprocessable Entity (validation failed)
- **500**: Internal Server Error

#### Performance Considerations

**Database Optimization**
- **Indexing**: Strategic database indexes
- **Query Optimization**: Efficient query design
- **Connection Pooling**: Database connection management
- **Read Replicas**: Read scaling (future)

**Caching Strategy**
- **Application Cache**: Frequently accessed data
- **Query Cache**: Database query results
- **Page Cache**: Full page caching where appropriate
- **CDN**: Static asset delivery optimization

**Frontend Optimization**
- **Asset Minification**: CSS/JS compression
- **Image Optimization**: Responsive images
- **Lazy Loading**: On-demand content loading
- **Browser Caching**: Client-side caching headers

**Monitoring & Analytics**
- **Application Performance Monitoring (APM)**
- **Database Query Analysis**
- **User Behavior Tracking**
- **Error Rate Monitoring**

#### Scalability

**Horizontal Scaling**
- **Load Balancing**: Multiple web servers
- **Database Scaling**: Read replicas and sharding
- **Microservices**: Service decomposition (future)
- **Container Orchestration**: Kubernetes deployment (future)

**Vertical Scaling**
- **Resource Allocation**: CPU and memory scaling
- **Database Optimization**: Query and schema optimization
- **Caching Layers**: Multi-level caching strategy
- **CDN Integration**: Global content delivery

**Capacity Planning**
- **User Growth**: Projected user base scaling
- **Data Growth**: Storage capacity planning
- **Traffic Patterns**: Peak load handling
- **Geographic Distribution**: Multi-region deployment (future)

---

## Getting Started

### System Requirements
- Modern web browser (Chrome, Firefox, Safari, Edge)
- Stable internet connection
- Valid email address for notifications

### First-Time Login
1. Open your web browser and navigate to the eGuidance Portal URL
2. Click on "Register" if you're a new user
3. Fill in the registration form with:
   - Full Name
   - Email Address
   - Student ID (optional)
   - Password
4. Click "Create Account"
5. Check your email for verification (if enabled)
6. Log in with your credentials

### Password Recovery
1. Click "Forgot Password?" on the login page
2. Enter your registered email address
3. Check your email for password reset instructions
4. Follow the link to create a new password

---

## Student Guide

### Dashboard Overview
Upon logging in, students see:
- **Quick Stats**: Number of active concerns and upcoming appointments
- **Navigation Menu**: Access to all main features
- **Recent Activity**: Latest concerns and appointments

### Submitting a Concern
1. Navigate to **Concerns → Submit New Concern**
2. Fill in the required information:
   - **Category**: Select the appropriate concern category
   - **Title**: Brief summary of your concern
   - **Description**: Detailed explanation of your concern
   - **Anonymous**: Check if you wish to remain anonymous
   - **Attachment**: Upload relevant documents (optional)
3. Click "Submit Concern"
4. You'll receive a confirmation and can track the status

### Viewing Concern Details
1. Go to **Concerns → My Concerns**
2. Click the "View" button next to any concern
3. View complete details including:
   - Submission date and category
   - Counselor response
   - Scheduled counseling date (if applicable)
   - Uploaded attachments

### Managing Appointments
1. Navigate to **Appointments → My Appointments**
2. View upcoming and past appointments
3. Click "View" to see appointment details:
   - Counselor information
   - Date and time
   - Related concerns
   - Session notes (after appointment)

### Rescheduling/Canceling Appointments
1. Go to **Appointments → My Appointments**
2. Find the appointment you want to modify
3. Click "Reschedule" or "Cancel" (if available)
4. Follow the prompts to complete the action
5. You'll receive email confirmation of changes

### Accessing Resources
1. Navigate to **Resources** in the sidebar
2. Browse available sections:
   - **Emergency Contacts**: Immediate help contacts
   - **Guidance Articles**: Self-help materials
   - **Self-Help Tools**: Interactive resources

### Profile Management
1. Click your profile picture/name in the top-right
2. Select "Profile" from the dropdown
3. Update your information:
   - **Personal Details**: Name, email, phone, etc.
   - **Profile Photo**: Upload a profile picture
   - **Password**: Change your password
4. Click "Update Profile" to save changes

---

## Counselor Guide

### Dashboard Overview
Counselors see:
- **Pending Concerns**: Number of concerns awaiting review
- **Today's Appointments**: Scheduled sessions for today
- **Upcoming Appointments**: Next 5 appointments
- **Quick Actions**: Access to common tasks

### Managing Student Concerns
1. Navigate to **Concerns → Student Concerns**
2. Review the list of submitted concerns
3. Click "View" to see full details including:
   - Student information (unless anonymous)
   - Concern details and attachments
   - Submission history

### Responding to Concerns
1. Open a concern from the list
2. Review all provided information and attachments
3. Click "Respond to Concern" (if status allows)
4. Fill in the response form:
   - **Counseling Date & Time**: Schedule the session
   - **Response**: Write your response to the student
5. Click "Submit Response"
6. An appointment is automatically created and the student is notified via email

### Managing Appointments
1. Go to **Appointments → My Appointments**
2. View all your scheduled appointments
3. Use the status buttons:
   - **Confirm**: Confirm a scheduled appointment
   - **Complete**: Mark appointment as finished
   - **Cancel**: Cancel an appointment with reason

### Appointment Workflow
1. **Scheduled**: Initial status after concern response
2. **Confirmed**: After counselor confirms the appointment
3. **Completed**: After the counseling session
4. **Cancelled**: If appointment is cancelled

### Adding Session Notes
1. Open an appointment that's been completed
2. Click "Add Session Note"
3. Fill in session details:
   - **Session Type**: Initial, follow-up, crisis, or group
   - **Notes**: Detailed session notes
   - **Recommendations**: Follow-up recommendations
   - **Confidential**: Mark if sensitive
4. Save the note

### Viewing Student Profiles
1. Click on any student's name in concerns or appointments
2. View their profile information:
   - Personal details
   - Concern history
   - Appointment history
   - Previous session notes

---

## Administrator Guide

### System Administration
Administrators have access to:
- **User Management**: Create and manage user accounts
- **System Settings**: Configure application settings
- **Reports**: Generate system usage reports
- **Audit Logs**: View system activity logs

### User Management
1. Navigate to **Administration → Users**
2. Create new users with appropriate roles:
   - **Student**: Standard student access
   - **Counselor**: Full counseling capabilities
   - **Administrator**: System administration
3. Assign counselors to students if required
4. Manage user permissions and access

### System Configuration
1. Go to **Settings → System Settings**
2. Configure:
   - **Email Settings**: SMTP configuration for notifications
   - **Appointment Settings**: Default durations, buffers
   - **Notification Preferences**: Default notification settings
   - **Security Settings**: Password policies, session timeouts

### Monitoring and Reports
1. Access **Reports → Dashboard**
2. View:
   - **Usage Statistics**: System usage metrics
   - **Concern Trends**: Common concern categories
   - **Appointment Analytics**: Counselor workload metrics
   - **User Activity**: Login and activity patterns

---

## Common Features

### Navigation
- **Sidebar Menu**: Main navigation to all features
- **Top Bar**: User profile, notifications, and quick actions
- **Breadcrumbs**: Navigation trail showing current location

### Search and Filter
- Use search bars to quickly find concerns or appointments
- Filter by date, status, category, or other criteria
- Sort results by relevance, date, or priority

### Notifications
- **In-App**: Real-time notifications in the interface
- **Email**: Automatic email notifications for:
  - Concern submissions
  - Appointment confirmations
  - Status changes
  - Important reminders

### File Attachments
- **Supported Formats**: Images (JPG, PNG, GIF), Documents (PDF, DOC, DOCX)
- **Size Limit**: Maximum 2MB per file
- **Security**: All files are scanned and stored securely

---

## Troubleshooting

### Common Issues

#### Login Problems
- **Forgot Password**: Use the "Forgot Password" link
- **Account Locked**: Contact administrator
- **Browser Issues**: Clear cache and cookies, try a different browser

#### Email Not Received
- **Check Spam Folder**: Look in spam/junk folders
- **Verify Email**: Ensure email address is correct in profile
- **Contact Admin**: If issues persist, contact system administrator

#### File Upload Issues
- **File Size**: Ensure file is under 2MB
- **File Type**: Check if file format is supported
- **Internet Connection**: Stable connection required for uploads

#### Appointment Issues
- **Time Conflicts**: Check for overlapping appointments
- **Browser Refresh**: Refresh page if appointments don't update
- **Time Zone**: Ensure correct time zone settings

### Performance Tips
- Use modern browsers for best performance
- Ensure stable internet connection
- Close unnecessary browser tabs
- Regularly clear browser cache

---

## FAQ

### General Questions

**Q: How do I reset my password?**
A: Click "Forgot Password?" on the login page and follow the email instructions.

**Q: Can I submit concerns anonymously?**
A: Yes, check the "Anonymous" option when submitting a concern.

**Q: How do I upload files with my concern?**
A: Use the attachment field on the concern submission form. Files must be under 2MB.

**Q: Will I receive email notifications?**
A: Yes, you'll receive emails for appointment confirmations, concern responses, and important updates.

### Student Questions

**Q: How long does it take to get a response to my concern?**
A: Response times vary, but counselors typically respond within 1-2 business days.

**Q: Can I reschedule my appointment?**
A: Yes, use the "Reschedule" button on your appointments page before the appointment time.

**Q: Are my concerns confidential?**
A: Yes, all concerns are confidential and only accessible to assigned counselors.

### Counselor Questions

**Q: How do I view student history?**
A: Click on the student's name in any concern or appointment to view their complete history.

**Q: Can I add private notes?**
A: Yes, mark session notes as "Confidential" to restrict access.

**Q: How are appointments created?**
A: Appointments are automatically created when you respond to a concern with a scheduled date.

---

## Contact Support

For technical support or questions:
- **Email**: support@eguidance.portal
- **Phone**: [Support Phone Number]
- **Help Desk**: Available Monday-Friday, 9:00 AM - 5:00 PM

For urgent counseling matters:
- **Emergency Hotline**: [Emergency Number]
- **On-Call Counselor**: [On-Call Contact]

---

## Version Information

**Current Version**: 1.0.0  
**Last Updated**: March 2026  
**Documentation Version**: 1.0

---

*This manual is regularly updated to reflect system changes and improvements. Check for the latest version on the portal's help section.*

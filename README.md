# eGuidance Portal

A comprehensive student guidance and counseling management system built with Laravel.

## Features

### Student Features
- **Dashboard**: Overview of concerns and appointments
- **Concern Submission**: Submit academic, personal, bullying, or career concerns with anonymous option
- **Appointment Scheduling**: Book appointments with available counselors
- **Status Tracking**: Monitor concern progress from submission to resolution
- **History**: View past concerns and counseling sessions

### Counselor Features
- **Dashboard**: Track pending concerns and upcoming appointments
- **Concern Management**: View and respond to student concerns
- **Appointment Management**: Confirm, complete, or cancel appointments
- **Session Notes**: Create confidential notes for each counseling session
- **Student Profiles**: Limited access to student information

### Admin Features
- **System Dashboard**: Comprehensive statistics and overview
- **User Management**: Create, edit, activate/deactivate users
- **Category Management**: Manage concern categories
- **Reports & Analytics**: Track trends and generate reports
- **System Settings**: Configure school policies and schedules

### Security & Privacy
- **Role-Based Access Control**: Secure access based on user roles
- **Confidential Data Handling**: Private session notes and sensitive information
- **Audit Logging**: Track system activities for security
- **Data Privacy Compliance**: Follow privacy best practices

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd eGuidance-Portal
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Administrator | admin@eguidance.com | password |
| Counselor | counselor@eguidance.com | password |
| Student | student@eguidance.com | password |

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Bootstrap 5 + Blade Templates
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Authentication**: Laravel UI with role-based middleware
- **Build Tools**: Vite

## Database Schema

The system includes 8 main tables:
- `users` - User accounts with role-based access
- `roles` - System roles (student, counselor, admin)
- `concern_categories` - Categories for student concerns
- `concerns` - Student concern submissions
- `appointments` - Counseling session scheduling
- `session_notes` - Private counselor notes
- `notifications` - User notifications system
- `audit_logs` - Security and activity logging

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── StudentController.php
│   │   ├── CounselorController.php
│   │   └── AdminController.php
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── student/
│   ├── counselor/
│   └── admin/
└── routes/
```

## Usage

1. **Students** can log in and submit concerns through the dashboard
2. **Counselors** can view concerns, manage appointments, and create session notes
3. **Administrators** have full system control and can manage users and settings

## Security Features

- Password hashing with bcrypt
- Role-based access control
- CSRF protection
- Input validation and sanitization
- Confidential session notes
- Audit trail for admin actions

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please open an issue in the repository.

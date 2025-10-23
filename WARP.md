# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

<<<<<<< HEAD
This is a Learning Management System (LMS) built with CodeIgniter 4 and Bootstrap 5. The project follows the MVC architectural pattern and includes a complete database schema for user management, courses, lessons, quizzes, and enrollment tracking.
=======
This is a Learning Management System (LMS) built with CodeIgniter 4 and Bootstrap 5. The project follows the MVC architectural pattern and includes a comprehensive admin interface, user authentication, course management, and database integration.
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)

## Development Commands

### Server Management
- **Start development server**: `php spark serve`
  - Default URL: http://localhost:8080
  - Alternative: http://127.0.0.1:8080

### Database Operations
- **Run migrations**: `php spark migrate`
- **Rollback last migration**: `php spark migrate:rollback`
- **Reset all migrations**: `php spark migrate:reset`
- **Seed database**: `php spark db:seed DatabaseSeeder`
- **Run specific seeder**: `php spark db:seed UserSeeder`

### Code Generation
- **Create migration**: `php spark make:migration CreateNewTable`
- **Create seeder**: `php spark make:seeder NewSeeder`
- **Create controller**: `php spark make:controller ControllerName`
- **Create model**: `php spark make:model ModelName`

### Testing
<<<<<<< HEAD
- **Run all tests**: `composer test` or `phpunit`
- **Run with coverage**: `phpunit --coverage-html build/coverage`
=======
- **Run all tests**: `composer test` or `vendor/bin/phpunit`
- **Run with coverage**: `vendor/bin/phpunit --coverage-html build/coverage`
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)

### Dependency Management
- **Install dependencies**: `composer install`
- **Update dependencies**: `composer update`

## Architecture Overview

### MVC Structure
The application follows CodeIgniter 4's MVC pattern:

- **Models** (`app/Models/`): Handle database operations and business logic
- **Views** (`app/Views/`): Present data to users with template inheritance
- **Controllers** (`app/Controllers/`): Process requests and coordinate between models and views

<<<<<<< HEAD
### Template System
- **Base Template**: `app/Views/Template.php` provides the main layout with Bootstrap 5
- **View Inheritance**: Views extend the template using `$this->extend('Template')`
- **Content Sections**: Views define content using `$this->section('content')`

### Database Schema
The system includes 6 main tables with proper foreign key relationships:
1. **users** - User accounts (students, instructors, admins)
2. **courses** - Course information
3. **lessons** - Lesson content linked to courses
4. **quizzes** - Quiz questions with JSON options
5. **enrollments** - Many-to-many relationship between users and courses
6. **submissions** - Quiz answers and scoring

### Routing Configuration
Routes are defined in `app/Config/Routes.php`:
- Clean URLs with custom route mappings
- RESTful patterns supported
- Multiple routes can point to the same controller method

## Key Development Patterns

### Controller Pattern
Controllers extend `BaseController` and return views with data arrays:
```php
public function methodName()
{
    $data = [
        'title' => 'Page Title',
        'content' => 'Page content'
    ];
    return view('template_name', $data);
}
```

### Database Migration Pattern
Migrations use the `forge` object for table creation:
- Define fields with proper types and constraints
- Add primary and foreign keys
- Include timestamps for audit trails
- Implement both `up()` and `down()` methods

### Seeder Pattern
Seeders follow dependency order:
1. Users (no dependencies)
2. Courses (no dependencies)  
3. Lessons (depends on courses)
4. Quizzes (depends on lessons)
5. Enrollments (depends on users and courses)

### View Data Passing
Controllers pass structured data arrays to views:
- Use associative arrays for complex data
- Include metadata like page titles and breadcrumbs
- Structure data to match view requirements
=======
### Controller Architecture
Key controllers and their responsibilities:

- **Admin**: Administrative functions (dashboard, user management, course management, activity logs)
- **Auth/AuthSimple**: User authentication and session management
- **Dashboard**: Main dashboard routing and display
- **Home**: Public pages (index, about, contact)
- **Student/Teacher**: Role-specific dashboard functionality
- **Course**: Course-related operations

### Template System
- **Base Template**: `app/Views/layouts/main.php` provides the main layout with Bootstrap 5
- **View Inheritance**: Views extend layouts using `$this->extend('layouts/main')`
- **Content Sections**: Views define content using `$this->section('content')`

### Database Schema
The system includes these main tables with proper foreign key relationships:

1. **users** - User accounts (students, instructors, admins)
2. **courses** - Course information and metadata
3. **lessons** - Lesson content linked to courses
4. **quizzes** - Quiz questions with JSON-formatted options
5. **enrollments** - Many-to-many relationship between users and courses
6. **submissions** - Quiz answers and scoring system

### Routing Configuration
Routes are defined in `app/Config/Routes.php`:

- **Public routes**: Home pages and authentication
- **Role-based groups**: Admin, teacher, and student routes with proper grouping
- **Clean URLs**: RESTful patterns with proper parameter handling
- **Authentication gates**: Protected routes with role-based access control

## Admin Interface

### Admin Dashboard Features
The admin interface provides comprehensive management capabilities:

- **User Management** (`/admin/manage-users`): View, edit, and manage all system users
- **Course Management** (`/admin/manage-courses`): Manage courses, lessons, and content
- **Activity Logs** (`/admin/activity-logs`): Monitor system activity and user actions
- **Statistics Dashboard**: Real-time metrics and system overview

### Admin Controller Methods
- `dashboard()`: Main admin dashboard with statistics
- `manageUsers()`: User management interface with database integration
- `manageCourses()`: Course management with CRUD operations
- `activityLogs()`: System activity monitoring (currently with mock data)

## Authentication System

### User Roles
- **Admin**: Full system access, user management, course oversight
- **Teacher**: Course creation, student management, grade management
- **Student**: Course enrollment, quiz participation, progress tracking

### Authentication Methods
- **Standard Auth** (`Auth` controller): Full database authentication with role management
- **Simple Auth** (`AuthSimple` controller): Simplified authentication for testing/development

### Session Management
- Role-based dashboard routing using `routeForRole()` method
- Session security with proper authorization checks
- Automatic redirection based on user roles
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)

## Frontend Framework

### Bootstrap 5 Integration
- CDN-based Bootstrap 5 and Bootstrap Icons
<<<<<<< HEAD
- Responsive grid system throughout
- Custom CSS in Template.php for enhanced styling
- Mobile-first responsive design

### Navigation System
- Active state detection using `current_url()` and `base_url()`
- Responsive navbar with mobile hamburger menu
- Icon-based navigation with Bootstrap Icons
=======
- Responsive grid system throughout all components
- Custom UI components with `.ui-card` styling
- Mobile-first responsive design approach

### Component Architecture
- **Navigation**: Responsive navbar with active state detection
- **Cards**: Consistent card-based layouts for content display
- **Tables**: Data tables with responsive design and proper styling
- **Forms**: Bootstrap-styled forms with validation states
- **Buttons**: Consistent button styling with gradient primary buttons

### Custom Styling
- Custom CSS classes: `.ui-card`, `.btn-gradient`, `.text-subtle`
- Bootstrap utility classes for spacing and layout
- Icon integration using Bootstrap Icons CDN

## Development Patterns

### Controller Pattern
Controllers extend `BaseController` and follow consistent patterns:

```php
public function methodName()
{
    // Authorization check for protected routes
    if ($redirect = $this->ensureAuthorized()) {
        return $redirect;
    }

    // Data preparation with database queries
    $data = [
        'title' => 'Page Title',
        'content' => $processedData
    ];
    
    return view('template_name', $data);
}
```

### Database Integration Pattern
Safe database operations with fallback handling:

```php
try {
    $db = \Config\Database::connect();
    $hasTable = static function ($db, string $table): bool {
        // Table existence check logic
    };
    
    if ($hasTable($db, 'table_name')) {
        $data = $db->table('table_name')->get()->getResultArray();
    }
} catch (\Throwable $e) {
    log_message('debug', 'DB operation failed: ' . $e->getMessage());
}
```

### View Data Structure
Controllers pass structured data arrays to views:
- Consistent naming conventions (`title`, `users`, `courses`, etc.)
- Proper escaping using `esc()` function
- Graceful handling of missing data with null coalescing
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)

## Testing Structure

### PHPUnit Configuration
- Tests located in `tests/` directory
<<<<<<< HEAD
- Separate test suites for unit, database, and session tests
=======
- Separate test categories: unit, database, session tests
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)
- Coverage reports generated in `build/` directory
- Bootstrap file: `system/Test/bootstrap.php`

### Test Categories
<<<<<<< HEAD
- **Unit Tests**: Core functionality testing
- **Database Tests**: Migration and seeder testing  
- **Session Tests**: User session management testing
=======
- **Unit Tests**: Core functionality and business logic
- **Database Tests**: Migration and seeder functionality
- **Session Tests**: Authentication and session management
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)

## Default Credentials

For development and testing:
- **Admin**: admin@lms.com / admin123
- **Instructor**: instructor@lms.com / instructor123
- **Student**: jane.student@lms.com / student123

<<<<<<< HEAD
## Environment Configuration

### Database Setup
1. Create database named `lms_terrado`
2. Configure `app/Config/Database.php` if needed
3. Copy `env` to `.env` and update settings
4. Run migrations and seeders

### Server Requirements
- PHP 8.1 or higher
- MySQL/MariaDB database
- Composer for dependency management
- mod_rewrite enabled for clean URLs

## File Structure Conventions

### Naming Patterns
- Controllers: PascalCase (e.g., `UserController.php`)
- Models: PascalCase (e.g., `UserModel.php`)
- Views: lowercase with underscores (e.g., `user_profile.php`)
- Migrations: timestamp prefix with descriptive name
- Seeders: descriptive name with "Seeder" suffix

### Directory Organization
- Configuration files in `app/Config/`
- Database files in `app/Database/Migrations/` and `app/Database/Seeds/`
- Business logic in `app/Controllers/` and `app/Models/`
- Templates and views in `app/Views/`
- Public assets in `public/`

## Development Workflow

### Adding New Features
1. Create database migrations if needed
2. Create/update models for data handling
3. Create controller methods for business logic
4. Create views for user interface
5. Update routes in `app/Config/Routes.php`
6. Write tests for new functionality

### Database Changes
1. Create migration: `php spark make:migration DescriptiveName`
2. Define schema changes in migration file
3. Run migration: `php spark migrate`
4. Create/update seeders if needed
5. Test with fresh database: `php spark migrate:reset && php spark migrate && php spark db:seed DatabaseSeeder`

## Common Troubleshooting

### Writable Directory Permissions
Ensure `writable/` directory has proper permissions:
=======
## Environment Setup

### Prerequisites
- PHP 8.1 or higher
- MySQL/MariaDB database server
- Composer for dependency management
- XAMPP/WAMP/LAMP stack
- mod_rewrite enabled for clean URLs

### Database Configuration
1. Create database named `lms_terrado`
2. Update `app/Config/Database.php` with connection details
3. Copy `env` to `.env` and configure environment variables
4. Run migrations: `php spark migrate`
5. Seed with sample data: `php spark db:seed DatabaseSeeder`

### Directory Permissions
Ensure writable permissions for:
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)
- `writable/cache/`
- `writable/logs/`
- `writable/session/`
- `writable/uploads/`

<<<<<<< HEAD
### URL Rewriting
For clean URLs, ensure `.htaccess` files are present in:
- `public/.htaccess` (main rewrite rules)
- `app/.htaccess` (deny direct access)
- `system/.htaccess` (deny direct access)

### Database Connection Issues
Check `app/Config/Database.php` settings:
- Hostname, username, password
- Database name exists
- MySQL service is running
- PHP mysqli extension is enabled
=======
## Common Development Tasks

### Adding New Admin Features
1. Add method to `Admin` controller with proper authorization
2. Add route to admin group in `app/Config/Routes.php`
3. Create corresponding view in `app/Views/admin/`
4. Update dashboard links if needed
5. Add database integration with proper error handling

### Database Schema Changes
1. Create migration: `php spark make:migration DescriptiveName`
2. Define schema in migration `up()` and `down()` methods
3. Run migration: `php spark migrate`
4. Update seeders if necessary
5. Test with fresh database: `php spark migrate:reset && php spark migrate && php spark db:seed DatabaseSeeder`

### Adding New User Roles
1. Update database schema with new role values
2. Extend `routeForRole()` method in controllers
3. Add new route groups in `Routes.php`
4. Create role-specific controllers and views
5. Update authorization logic in base controllers

## Troubleshooting

### Common Issues

**Database Connection Problems:**
- Verify MySQL service is running
- Check database name, credentials in `app/Config/Database.php`
- Ensure database exists and is accessible
- Verify PHP mysqli extension is loaded

**URL Rewriting Issues:**
- Ensure `.htaccess` files are present in public/ directory
- Verify mod_rewrite is enabled in Apache
- Check virtual host configuration for AllowOverride

**Permission Errors:**
- Set proper permissions on `writable/` directory (755 or 777)
- Verify web server user has write access
- Check SELinux settings on Linux systems

**Session Issues:**
- Clear session files in `writable/session/`
- Verify session configuration in `app/Config/Session.php`
- Check cookie settings for domain/path conflicts

### Development Workflow

**Feature Development:**
1. Create feature branch: `git checkout -b feature/new-feature`
2. Add database migrations if needed
3. Create/update controllers with business logic
4. Build views with proper template inheritance
5. Update routes and test functionality
6. Write tests for new features
7. Commit changes: `git commit -m "Add new feature"`

**Bug Fixes:**
1. Reproduce issue in development environment
2. Check error logs in `writable/logs/`
3. Use CodeIgniter's debugging tools (`ENVIRONMENT = development`)
4. Fix issue and test thoroughly
5. Update relevant tests if applicable

## Security Considerations

### Data Sanitization
- Always use `esc()` function for output
- Validate and sanitize user input
- Use parameterized queries for database operations
- Implement CSRF protection for forms

### Authentication Security
- Implement proper password hashing
- Use secure session management
- Add rate limiting for login attempts
- Implement proper logout functionality

### Access Control
- Role-based access control for all admin functions
- Proper authorization checks in controller methods
- Session validation for protected routes
- Input validation and sanitization

## Performance Considerations

### Database Optimization
- Use database query builder for complex queries
- Implement proper indexing on frequently queried columns
- Use pagination for large datasets
- Cache frequently accessed data when appropriate

### Frontend Optimization
- Minimize HTTP requests with CDN resources
- Use responsive images and proper image optimization
- Implement proper caching headers
- Minify CSS/JS in production environment

This documentation provides the essential information for working effectively with this CodeIgniter 4 LMS project. For additional details, refer to the CodeIgniter 4 documentation and the project's existing documentation files.
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)

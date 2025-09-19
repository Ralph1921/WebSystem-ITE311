# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

This is a Learning Management System (LMS) built with CodeIgniter 4 and Bootstrap 5. The project follows the MVC architectural pattern and includes a complete database schema for user management, courses, lessons, quizzes, and enrollment tracking.

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
- **Run all tests**: `composer test` or `phpunit`
- **Run with coverage**: `phpunit --coverage-html build/coverage`

### Dependency Management
- **Install dependencies**: `composer install`
- **Update dependencies**: `composer update`

## Architecture Overview

### MVC Structure
The application follows CodeIgniter 4's MVC pattern:

- **Models** (`app/Models/`): Handle database operations and business logic
- **Views** (`app/Views/`): Present data to users with template inheritance
- **Controllers** (`app/Controllers/`): Process requests and coordinate between models and views

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

## Frontend Framework

### Bootstrap 5 Integration
- CDN-based Bootstrap 5 and Bootstrap Icons
- Responsive grid system throughout
- Custom CSS in Template.php for enhanced styling
- Mobile-first responsive design

### Navigation System
- Active state detection using `current_url()` and `base_url()`
- Responsive navbar with mobile hamburger menu
- Icon-based navigation with Bootstrap Icons

## Testing Structure

### PHPUnit Configuration
- Tests located in `tests/` directory
- Separate test suites for unit, database, and session tests
- Coverage reports generated in `build/` directory
- Bootstrap file: `system/Test/bootstrap.php`

### Test Categories
- **Unit Tests**: Core functionality testing
- **Database Tests**: Migration and seeder testing  
- **Session Tests**: User session management testing

## Default Credentials

For development and testing:
- **Admin**: admin@lms.com / admin123
- **Instructor**: instructor@lms.com / instructor123
- **Student**: jane.student@lms.com / student123

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
- `writable/cache/`
- `writable/logs/`
- `writable/session/`
- `writable/uploads/`

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

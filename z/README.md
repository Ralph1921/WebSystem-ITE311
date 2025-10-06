# Learning Management System (LMS) - ITE311

A comprehensive Learning Management System built with CodeIgniter 4 and Bootstrap 5.

## 🚀 Features

- **Modern UI/UX**: Built with Bootstrap 5 and Bootstrap Icons
- **Responsive Design**: Mobile-first approach with responsive navigation
- **Database Integration**: Complete database schema with migrations and seeders
- **User Management**: Support for students, instructors, and administrators
- **Course Management**: Full course and lesson management system
- **Quiz System**: Interactive quizzes with multiple choice questions
- **Progress Tracking**: Student enrollment and submission tracking

## 🛠️ Technology Stack

- **Backend**: PHP 8.0+ with CodeIgniter 4
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Database**: MySQL/MariaDB
- **Server**: XAMPP/WAMP/LAMP

## 📋 Prerequisites

Before running this project, make sure you have:

- PHP 8.0 or higher
- MySQL/MariaDB
- XAMPP, WAMP, or LAMP server
- Git (for version control)
- Composer (for dependency management)

## 🚀 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/WebSystem-ITE311.git
cd WebSystem-ITE311
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Database Setup

1. Create a new database named `lms_terrado` in your MySQL server
2. Update database configuration in `app/Config/Database.php` if needed
3. Run migrations to create tables:

```bash
php spark migrate
```

4. Seed the database with sample data:

```bash
php spark db:seed DatabaseSeeder
```

### Step 4: Configure Environment

1. Copy the `env` file to `.env`
2. Update the configuration as needed

### Step 5: Run the Application

Start the development server:

```bash
php spark serve
```

Visit `http://localhost:8080` or `http://127.0.0.1:8080` in your browser.

## 📁 Project Structure

```
ITE311-TERRADO/
├── app/
│   ├── Config/          # Configuration files
│   ├── Controllers/     # Application controllers
│   ├── Database/        # Migrations and seeders
│   ├── Models/          # Data models
│   └── Views/           # View templates
├── public/              # Web accessible files
├── system/              # CodeIgniter system files
├── vendor/              # Composer dependencies
└── writable/            # Writable directories
```

## 🗄️ Database Schema

The application includes the following main tables:

- **users**: User accounts (students, instructors, admins)
- **courses**: Course information
- **lessons**: Lesson content
- **quizzes**: Quiz questions and answers
- **enrollments**: Student course enrollments
- **submissions**: Quiz submissions and scores

## 🎨 UI Components

### Navigation
- Responsive navbar with Bootstrap 5
- Mobile-friendly hamburger menu
- Active page highlighting

### Homepage Sections
- **Hero Section**: Welcome message with call-to-action buttons
- **Features Section**: Key LMS features with icons
- **Statistics Section**: Platform statistics
- **Call-to-Action**: Registration and course browsing

### Styling
- Custom CSS for enhanced visual appeal
- Bootstrap 5 utility classes
- Responsive grid system
- Modern color scheme

## 🔧 Development

### Running Migrations

```bash
# Run all pending migrations
php spark migrate

# Rollback last migration
php spark migrate:rollback

# Reset all migrations
php spark migrate:reset
```

### Running Seeders

```bash
# Run all seeders
php spark db:seed DatabaseSeeder

# Run specific seeder
php spark db:seed UserSeeder
```

### Creating New Migrations

```bash
php spark make:migration CreateNewTable
```

### Creating New Seeders

```bash
php spark make:seeder NewSeeder
```

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

## 🎯 Default Login Credentials

For testing purposes, you can use these credentials:

- **Admin**: admin@lms.com / admin123
- **Instructor**: instructor@lms.com / instructor123
- **Student**: jane.student@lms.com / student123

## 📊 Sample Data

The application comes with sample data including:
- 5 users (1 admin, 1 instructor, 3 students)
- 4 courses (Web Development, Database, PHP, CodeIgniter)
- 9 lessons across different courses
- 8 quiz questions
- 6 student enrollments

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**TERRADO** - ITE311 Student

## 📞 Support

If you have any questions or need help, please contact:
- Email: your.email@example.com
- GitHub: [@yourusername](https://github.com/yourusername)

---

**Note**: This is a learning project for ITE311 course. The application is designed for educational purposes and demonstrates modern web development practices with CodeIgniter 4 and Bootstrap 5.
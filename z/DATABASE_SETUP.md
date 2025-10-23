# Database Setup Instructions

## Manual Database Creation

Since the CodeIgniter migration might not work due to database connection issues, please follow these steps to manually create the database and users table:

### Step 1: Create Database
1. Open phpMyAdmin in your browser: `http://localhost/phpmyadmin`
2. Click on "New" to create a new database
3. Enter database name: `ite311_terrado`
4. Click "Create"

### Step 2: Create Users Table
Execute the following SQL command in phpMyAdmin:

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Step 3: Test the Migration (Optional)
After manual database creation, you can try running the CodeIgniter migration:
```bash
php spark migrate
```

### Step 4: Test the Application
1. Visit: `http://localhost/ITE311-TERRADO/public/register`
2. Create a test account
3. Login with the created account
4. Access the dashboard

## Database Configuration
The database configuration is set in `app/Config/Database.php`:
- Host: localhost
- Username: root
- Password: (empty)
- Database: ite311_terrado

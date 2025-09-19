<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - WebSystem</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #34495e;
        }
        
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin-top: 2rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .welcome-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: white;
            font-weight: 300;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }
        
        .btn-group {
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: white;
            color: #667eea;
        }
        
        .btn-primary:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            border: 2px solid white;
            color: white;
            background-color: transparent;
        }
        
        .btn-outline:hover {
            background-color: white;
            color: #667eea;
            transform: translateY(-2px);
        }
        
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-menu {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
                text-align: center;
            }
            
            .main-content {
                padding: 2rem 1rem;
                margin: 1rem;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="nav-container">
            <a href="<?= base_url() ?>" class="logo">WebSystem</a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="<?= base_url() ?>" class="active">Home</a></li>
                    <li><a href="<?= base_url('/about') ?>">About</a></li>
                    <li><a href="<?= base_url('/contact') ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <h1 class="welcome-title">Welcome to My CI Project</h1>
        <p class="welcome-subtitle">This is the homepage. Use the navigation bar to explore About and Contact pages.</p>
        
        <div class="btn-group">
            <a href="<?= base_url('/about') ?>" class="btn btn-primary">Learn About Us</a>
            <a href="<?= base_url('/contact') ?>" class="btn btn-outline">Contact Us</a>
        </div>
    </main>

    <footer class="footer">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <p>&copy; 2025 My Website</p>
        </div>
    </footer>
</body>
</html>

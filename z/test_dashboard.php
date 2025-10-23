<?php
// Test what your dashboard will look like after login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-900: #0b1220;
            --bg-800: #0f172a;
            --card-700: #1f2a44;
            --text-050: #f8fafc;
            --text-100: #e2e8f0;
            --text-300: #cbd5e1;
            --text-400: #94a3b8;
            --border-600: #334155;
            --brand-1: #2563eb;
            --brand-2: #1d4ed8;
            --brand-1-hover: #3b82f6;
            --brand-2-hover: #2563eb;
        }

        body {
            background: radial-gradient(1200px 600px at 10% -10%, rgba(59,130,246,.12), transparent),
                        radial-gradient(1000px 500px at 90% 10%, rgba(29,78,216,.10), transparent),
                        var(--bg-900);
            color: var(--text-100);
            min-height: 100vh;
        }

        .app-nav { background: #0d1628; border-bottom: 1px solid rgba(255,255,255,.04); }
        .brand { color: var(--text-100); font-weight: 600; letter-spacing: .2px; text-decoration: none; }
        .brand:hover { color: #fff; }
        .nav-link-top { color: var(--text-300); text-decoration: none; margin: 0 15px; }
        .nav-link-top:hover { color: #ffffff; }

        .ui-card { background: rgba(31, 42, 68, 0.95); border: 1px solid rgba(255,255,255,.06);
                   box-shadow: 0 20px 50px rgba(0,0,0,.55); border-radius: 14px; }

        h1, h2, h3, h4, h5 { color: var(--text-050); }
        .text-subtle { color: var(--text-400); }

        .alert { border-radius: 12px; }
        main.page { min-height: calc(100vh - 72px); }
    </style>
</head>
<body>
    <!-- Top nav -->
    <nav class="app-nav py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="brand" href="/">WebSystem</a>
            <div>
                <a class="nav-link-top" href="/">Home</a>
                <a class="nav-link-top" href="/about">About</a>
                <a class="nav-link-top" href="/contact">Contact</a>
                <a class="btn btn-outline-primary btn-sm" href="/logout">Logout</a>
            </div>
        </div>
    </nav>

    <main class="page py-4">
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Welcome back, Terrado User!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <div class="alert alert-info" role="alert">
                Welcome, terrado@gmail.com!
            </div>

            <div class="alert alert-dark" role="alert">
                This is a protected page only visible after login.
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
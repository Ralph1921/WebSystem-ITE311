<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? 'WebSystem') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?= $this->renderSection('head') ?>
    <style>
        :root {
            --bg-900: #0b1220;   /* page background */
            --bg-800: #0f172a;   /* controls background */
            --card-700: #1f2a44; /* card background */
            --text-050: #f8fafc; /* paper */
            --text-100: #e2e8f0; /* primary text */
            --text-300: #cbd5e1; /* secondary text */
            --text-400: #94a3b8; /* muted text */
            --border-600: #334155; /* borders */
            --brand-1: #2563eb; /* gradient start */
            --brand-2: #1d4ed8; /* gradient end */
            --brand-1-hover: #3b82f6; /* hover start */
            --brand-2-hover: #2563eb; /* hover end */
        }

        body {
            background: radial-gradient(1200px 600px at 10% -10%, rgba(59,130,246,.12), transparent),
                        radial-gradient(1000px 500px at 90% 10%, rgba(29,78,216,.10), transparent),
                        var(--bg-900);
            color: var(--text-100);
            min-height: 100vh;
        }

        /* Top navigation */
        .app-nav { background: #0d1628; border-bottom: 1px solid rgba(255,255,255,.04); }
        .brand { color: var(--text-100); font-weight: 600; letter-spacing: .2px; text-decoration: none; }
        .brand:hover { color: #fff; }
        .nav-link-top { color: var(--text-300); text-decoration: none; }
        .nav-link-top:hover { color: #ffffff; }

        /* Generic card styling */
        .ui-card { background: rgba(31, 42, 68, 0.95); border: 1px solid rgba(255,255,255,.06);
                   box-shadow: 0 20px 50px rgba(0,0,0,.55); border-radius: 14px; }

        /* Headings */
        h1, h2, h3, h4, h5 { color: var(--text-050); }
        .text-subtle { color: var(--text-400); }

        /* Inputs */
        .form-label { color: var(--text-300); font-weight: 600; }
        .form-control { background-color: var(--bg-800); border-color: var(--border-600); color: var(--text-100); }
        .form-control::placeholder { color: var(--text-400); }
        .form-control:focus { background-color: var(--bg-800); color: var(--text-100); border-color: var(--brand-1);
                               box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15); }

        /* Buttons */
        .btn-gradient { background-image: linear-gradient(90deg, var(--brand-1), var(--brand-2));
                        border: 0; color: #fff; font-weight: 700; letter-spacing: .2px; }
        .btn-gradient:hover { background-image: linear-gradient(90deg, var(--brand-1-hover), var(--brand-2-hover));
                              color: #fff; filter: saturate(1.05); }

        .muted-link { color: var(--text-400); }
        .muted-link a { color: var(--brand-1); text-decoration: none; }
        .muted-link a:hover { text-decoration: underline; }

        .alert { border-radius: 12px; }

        main.page { min-height: calc(100vh - 72px); }
    </style>
</head>
<body>
    <!-- Top nav -->
    <nav class="app-nav py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="brand" href="<?= base_url('/') ?>">WebSystem</a>
            <div>
                <?php
                    $navOverride = trim($this->renderSection('navRight'));
                    if ($navOverride !== '') {
                        echo $navOverride;
                    } else {
                        $isLoggedIn = (bool) session('logged_in');
                        $role = strtolower((string) session('role'));
                        $dash = base_url('/dashboard');
                        if ($role === 'admin') { $dash = base_url('/admin/dashboard'); }
                        elseif ($role === 'teacher') { $dash = base_url('/teacher/dashboard'); }
                        elseif ($role === 'student') { $dash = base_url('/student/dashboard'); }
                ?>
                        <?php if (!$isLoggedIn): ?>
                            <a class="nav-link-top me-3" href="<?= base_url('/login') ?>">Login</a>
                            <a class="btn btn-gradient btn-sm" href="<?= base_url('/register') ?>">Register</a>
                        <?php else: ?>
                            <a class="nav-link-top me-3" href="<?= $dash ?>">Dashboard</a>
                            <?php if ($role === 'admin'): ?>
                                <a class="nav-link-top me-3" href="#">Manage Users</a>
                                <a class="nav-link-top me-3" href="#">Manage Courses</a>
                            <?php elseif ($role === 'teacher'): ?>
                                <a class="nav-link-top me-3" href="#">My Courses</a>
                                <a class="nav-link-top me-3" href="#">Create Course</a>
                            <?php elseif ($role === 'student'): ?>
                                <a class="nav-link-top me-3" href="#">My Enrollments</a>
                                <a class="nav-link-top me-3" href="#">Grades</a>
                            <?php endif; ?>
                            <a class="btn btn-outline-light btn-sm" href="<?= base_url('/logout') ?>">Logout</a>
                        <?php endif; ?>
                <?php } ?>
            </div>
        </div>
    </nav>

    <main class="page py-4">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('body_end') ?>
</body>
</html>

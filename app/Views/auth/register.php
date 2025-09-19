<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - WebSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-900: #0b1220;
            --bg-800: #0f172a;
            --card-700: #1f2a44;
            --text-100: #e2e8f0;
            --text-300: #cbd5e1;
            --text-400: #94a3b8;
            --border-600: #334155;
            --brand-1: #2563eb;
            --brand-2: #1d4ed8;
            --brand-1-hover: #3b82f6;
            --brand-2-hover: #2563eb;
        }

        body { background: radial-gradient(1200px 600px at 10% -10%, rgba(59,130,246,.12), transparent),
                              radial-gradient(1000px 500px at 90% 10%, rgba(29,78,216,.10), transparent),
                              var(--bg-900); color: var(--text-100); min-height: 100vh; }

        .app-nav { background: #0d1628; border-bottom: 1px solid rgba(255,255,255,.04); }
        .brand { color: var(--text-100); font-weight: 600; letter-spacing: .2px; text-decoration: none; }
        .nav-link-top { color: var(--text-300); text-decoration: none; }
        .nav-link-top:hover { color: #ffffff; }

        .auth-card { background: rgba(31, 42, 68, 0.95); border: 1px solid rgba(255,255,255,.06);
                     box-shadow: 0 20px 50px rgba(0,0,0,.55); border-radius: 14px; }
        .auth-title { font-weight: 700; color: #fff; }
        .auth-sub { color: var(--text-400); }

        .form-label { color: var(--text-300); font-weight: 600; }
        .form-control { background-color: var(--bg-800); border-color: var(--border-600); color: var(--text-100); }
        .form-control::placeholder { color: var(--text-400); }
        .form-control:focus { background-color: var(--bg-800); color: var(--text-100); border-color: var(--brand-1);
                               box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15); }

        .btn-gradient { background-image: linear-gradient(90deg, var(--brand-1), var(--brand-2));
                        border: 0; color: #fff; font-weight: 700; letter-spacing: .2px; }
        .btn-gradient:hover { background-image: linear-gradient(90deg, var(--brand-1-hover), var(--brand-2-hover));
                              color: #fff; filter: saturate(1.05); }

        .muted-link { color: var(--text-400); }
        .muted-link a { color: var(--brand-1); text-decoration: none; }
        .muted-link a:hover { text-decoration: underline; }

        .alert { border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="app-nav py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="brand" href="<?= base_url('/') ?>">WebSystem</a>
            <a class="nav-link-top" href="<?= base_url('/login') ?>">Login</a>
        </div>
    </nav>

    <div class="container d-flex align-items-start justify-content-center" style="min-height: calc(100vh - 72px);">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            <div class="auth-card p-4 p-md-5 mt-5">
                <h2 class="auth-title text-center mb-2">Create Account</h2>
                <p class="auth-sub text-center mb-4">Sign up to get started</p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/register') ?>" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ?>" placeholder="Juan Dela Cruz" required>
                        <?php if (isset($validation) && $validation->hasError('name')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('name') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="you@example.com" required>
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="••••••••" required>
                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password_confirm') ? 'is-invalid' : '' ?>" id="password_confirm" name="password_confirm" placeholder="••••••••" required>
                        <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password_confirm') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-gradient py-2">Create Account</button>
                    </div>
                </form>

                <p class="text-center muted-link mt-3 mb-0">
                    Already have an account? <a href="<?= base_url('/login') ?>">Login here</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

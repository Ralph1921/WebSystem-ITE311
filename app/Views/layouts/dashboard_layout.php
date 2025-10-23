<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>WebSystem - Dashboard</title>
  <link rel="stylesheet" href="<?= base_url('css/student-dashboard.css') ?>" />
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="brand">WebSystem</div>

      <nav class="navlinks">
        <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('admin/users') ?>">Manage Users</a>
        <a href="<?= base_url('admin/courses') ?>">Manage Courses</a>
        <a class="active" href="<?= base_url('admin/student-dashboard') ?>">Student Dashboard</a>
      </nav>

      <div class="top-right">
        <div class="user-name"><?= esc(session()->get('user_name') ?? 'Student One') ?></div>
        <a class="btn-logout" href="<?= base_url('logout') ?>">Logout</a>
      </div>
    </div>
  </header>

  <main>
    <?= $this->renderSection('content') ?>
  </main>
</body>
</html>

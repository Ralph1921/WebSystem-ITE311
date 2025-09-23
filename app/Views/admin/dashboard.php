<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <h1 class="mb-1">Admin Dashboard</h1>
    <p class="text-subtle">Manage users, courses, and monitor system activity.</p>
  </div>

  <div class="col-md-4">
    <div class="ui-card p-4 h-100">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Total Users</h5>
        <span class="badge bg-primary">All</span>
      </div>
      <div class="display-5 fw-bold mt-2"><?= esc($stats['totalUsers'] ?? 0) ?></div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="ui-card p-4 h-100">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Total Courses</h5>
        <span class="badge bg-success">Courses</span>
      </div>
      <div class="display-5 fw-bold mt-2"><?= esc($stats['totalCourses'] ?? 0) ?></div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="ui-card p-4 h-100">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Active Teachers</h5>
        <span class="badge bg-info">Teachers</span>
      </div>
      <div class="display-5 fw-bold mt-2"><?= esc($stats['activeTeachers'] ?? 0) ?></div>
    </div>
  </div>

  <div class="col-12">
    <div class="ui-card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Quick Actions</h5>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <a href="#" class="btn btn-gradient">Manage Users</a>
        <a href="#" class="btn btn-outline-light">Manage Courses</a>
        <a href="#" class="btn btn-outline-light">View Activity Logs</a>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <h1 class="mb-1 text-white">Student Dashboard</h1>
    <p class="text-subtle">Your enrolled courses and upcoming deadlines.</p>
  </div>

  <!-- Dashboard summary cards -->
  <div class="col-md-4">
    <div class="card bg-dark text-white p-4 shadow-sm rounded-3">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="small text-muted">Total Courses</div>
          <h2 class="fw-bold"><?= esc($totalCourses ?? 0) ?></h2>
        </div>
        <span class="badge bg-primary">All</span>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-dark text-white p-4 shadow-sm rounded-3">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="small text-muted">My Enrollments</div>
          <h2 class="fw-bold"><?= esc($myEnrollments ?? 0) ?></h2>
        </div>
        <span class="badge bg-success">Enrolled</span>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-dark text-white p-4 shadow-sm rounded-3">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="small text-muted">Active Courses</div>
          <h2 class="fw-bold"><?= esc($activeCourses ?? 0) ?></h2>
        </div>
        <span class="badge bg-info text-dark">Active</span>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="col-12">
    <div class="card bg-dark text-white p-4 mt-3 shadow-sm rounded-3">
      <h5>Quick Actions</h5>
      <div class="mt-3">
        <a href="/student/courses" class="btn btn-primary me-2">Browse Courses</a>
        <a href="/student/dashboard#my-courses" class="btn btn-outline-light me-2">My Courses</a>
        <a href="/student/activity" class="btn btn-outline-light">Activity</a>
      </div>
    </div>
  </div>

  <!-- My Enrollments List -->
  <div class="col-12">
    <div class="card bg-dark text-white p-4 mt-3 shadow-sm rounded-3">
      <h5 class="mb-3">My Enrollments</h5>
      <?php if (!empty($enrollments)): ?>
        <div class="list-group list-group-flush">
          <?php foreach ($enrollments as $enroll): ?>
            <div class="list-group-item bg-transparent text-white border-secondary d-flex justify-content-between">
              <div>
                <strong><?= esc($enroll['title'] ?? 'Untitled Course') ?></strong><br>
                <small class="text-muted"><?= esc($enroll['description'] ?? '') ?></small>
              </div>
              <span class="badge bg-secondary align-self-center"><?= esc($enroll['status'] ?? 'Enrolled') ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted mb-0">No enrollments yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>


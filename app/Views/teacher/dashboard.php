<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <h1 class="mb-1">Teacher Dashboard</h1>
    <p class="text-subtle">Your courses and recent activity.</p>
  </div>

  <div class="col-12">
    <div class="ui-card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">My Courses</h5>
        <a href="#" class="btn btn-gradient">Create Course</a>
      </div>
      <?php if (!empty($courses)): ?>
        <div class="list-group list-group-flush">
          <?php foreach ($courses as $course): ?>
            <a href="#" class="list-group-item list-group-item-action bg-transparent text-white border-secondary">
              <?= esc($course['title']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-subtle mb-0">No courses yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

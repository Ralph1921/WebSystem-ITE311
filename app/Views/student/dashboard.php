<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <h1 class="mb-1">Student Dashboard</h1>
    <p class="text-subtle">Your enrolled courses and upcoming deadlines.</p>
  </div>

  <div class="col-12">
    <div class="ui-card p-4">
      <h5 class="mb-3">My Enrollments</h5>
      <?php if (!empty($enrollments)): ?>
        <div class="list-group list-group-flush">
          <?php foreach ($enrollments as $enroll): ?>
            <div class="list-group-item bg-transparent text-white border-secondary">
              <?= esc($enroll['course'] ?? 'Course') ?>
              <span class="ms-2 badge bg-secondary"><?= esc($enroll['status'] ?? 'Enrolled') ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-subtle mb-0">No enrollments yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

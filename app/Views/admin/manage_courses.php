<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h1 class="mb-1">Manage Courses</h1>
        <p class="text-subtle">View and manage all courses in the system.</p>
      </div>
      <div>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-light me-2">← Back to Dashboard</a>
        <button class="btn btn-gradient">Add New Course</button>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="ui-card p-4">
      <div class="table-responsive">
        <?php if (!empty($courses)): ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Instructor</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($courses as $course): ?>
            <tr>
              <td><?= esc($course['id'] ?? 'N/A') ?></td>
              <td><?= esc($course['title'] ?? 'N/A') ?></td>
              <td><?= esc(substr($course['description'] ?? '', 0, 50)) ?><?= strlen($course['description'] ?? '') > 50 ? '...' : '' ?></td>
              <td><?= esc($course['instructor_id'] ?? $course['instructor'] ?? 'N/A') ?></td>
              <td><?= isset($course['created_at']) ? date('Y-m-d', strtotime($course['created_at'])) : 'N/A' ?></td>
              <td>
                <button class="btn btn-sm btn-outline-light me-1">Edit</button>
                <button class="btn btn-sm btn-outline-info me-1">View</button>
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="text-center py-5">
          <div class="display-1 text-muted mb-3">📚</div>
          <h4>No Courses Found</h4>
          <p class="text-subtle mb-4">No courses are currently in the system, or the database is not set up.</p>
          <div class="alert alert-info">
            <strong>Note:</strong> To populate courses, run the database migrations and seeders:
            <br><code>php spark migrate && php spark db:seed DatabaseSeeder</code>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
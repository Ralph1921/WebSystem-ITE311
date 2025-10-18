<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h1 class="mb-1">Manage Users</h1>
        <p class="text-subtle">View and manage all users in the system.</p>
      </div>
      <div>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-light me-2">← Back to Dashboard</a>
        <button class="btn btn-gradient">Add New User</button>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="ui-card p-4">
      <div class="table-responsive">
        <?php if (!empty($users)): ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
              <td><?= esc($user['id'] ?? 'N/A') ?></td>
              <td><?= esc($user['name'] ?? $user['username'] ?? 'N/A') ?></td>
              <td><?= esc($user['email'] ?? 'N/A') ?></td>
              <td>
                <span class="badge bg-<?= esc($user['role']) === 'admin' ? 'primary' : (esc($user['role']) === 'teacher' ? 'success' : 'info') ?>">
                  <?= esc($user['role'] ?? 'N/A') ?>
                </span>
              </td>
              <td><?= isset($user['created_at']) ? date('Y-m-d', strtotime($user['created_at'])) : 'N/A' ?></td>
              <td>
                <button class="btn btn-sm btn-outline-light me-1">Edit</button>
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="text-center py-5">
          <div class="display-1 text-muted mb-3">👥</div>
          <h4>No Users Found</h4>
          <p class="text-subtle mb-4">No users are currently in the system, or the database is not set up.</p>
          <div class="alert alert-info">
            <strong>Note:</strong> To populate users, run the database migrations and seeders:
            <br><code>php spark migrate && php spark db:seed DatabaseSeeder</code>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
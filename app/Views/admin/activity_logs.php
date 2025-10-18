<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h1 class="mb-1">Activity Logs</h1>
        <p class="text-subtle">Monitor system activity and user actions.</p>
      </div>
      <div>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-light me-2">← Back to Dashboard</a>
        <button class="btn btn-outline-light">Export Logs</button>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="ui-card p-4">
      <div class="table-responsive">
        <?php if (!empty($logs)): ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Action</th>
              <th>Timestamp</th>
              <th>IP Address</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= esc($log['id']) ?></td>
              <td><?= esc($log['user']) ?></td>
              <td>
                <span class="badge bg-<?= 
                  strpos($log['action'], 'login') !== false ? 'success' : 
                  (strpos($log['action'], 'created') !== false ? 'primary' : 'info') 
                ?>">
                  <?= esc($log['action']) ?>
                </span>
              </td>
              <td><?= esc($log['timestamp']) ?></td>
              <td>
                <code><?= esc($log['ip_address']) ?></code>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="text-center py-5">
          <div class="display-1 text-muted mb-3">📈</div>
          <h4>No Activity Logs Found</h4>
          <p class="text-subtle mb-4">No activity logs are available at this time.</p>
          <div class="alert alert-info">
            <strong>Note:</strong> Activity logs are currently using mock data for demonstration purposes.
            In a production environment, these would be stored in a dedicated logs table.
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
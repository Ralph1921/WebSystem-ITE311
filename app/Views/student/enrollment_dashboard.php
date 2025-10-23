<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h1 class="mb-4"><?= esc($title) ?></h1>

  <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="ui-card p-4">
    <h4 class="mb-3">Available Courses</h4>

    <?php if (!empty($courses)): ?>
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Course Title</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($courses as $i => $course): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= esc($course['title']) ?></td>
              <td><?= esc($course['description']) ?></td>
              <td>
                <form action="<?= base_url('student/enroll/' . $course['id']) ?>" method="post" class="d-inline">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm btn-gradient">Enroll</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">No courses available for enrollment.</p>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>

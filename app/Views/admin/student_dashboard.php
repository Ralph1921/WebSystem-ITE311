<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="student-container">
  <?php if (session()->getFlashdata('message')): ?>
    <div class="flash"><?= esc(session()->getFlashdata('message')) ?></div>
  <?php endif ?>

  <div class="hero">
    <div>
      <h1 class="title">Student Dashboard</h1>
      <div class="subtitle">Welcome back, <strong><?= esc($userName) ?></strong> — view your courses and activity.</div>
    </div>
  </div>

  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-title">Total Enrolled</div>
      <div class="stat-value"><?= count($enrolled) ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-title">Available Courses</div>
      <div class="stat-value"><?= count($available) ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-title">Active Teachers</div>
      <div class="stat-value">1</div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-row">
      <div class="panel-col">
        <div class="panel-card">
          <div class="card-title">Enrolled Courses</div>
          <div id="enrolled-list">
            <?php if (!empty($enrolled)): ?>
              <?php foreach ($enrolled as $c): ?>
                <div class="course">
                  <div>
                    <div class="course-title"><?= esc($c['title']) ?></div>
                    <div class="course-meta">Instructor: <?= esc($c['instructor'] ?? 'TBA') ?></div>
                  </div>
                  <div class="course-grade"><?= esc($c['grade'] ?? '-') ?></div>
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <div class="empty">No enrolled courses yet.</div>
            <?php endif ?>
          </div>
        </div>
      </div>

      <div class="panel-col">
        <div class="panel-card">
          <div class="card-title">Available Courses</div>
          <div id="available-list">
            <?php if (!empty($available)): ?>
              <?php foreach ($available as $c): ?>
                <div class="course">
                  <div>
                    <div class="course-title"><?= esc($c['title']) ?></div>
                    <div class="course-meta"><?= esc($c['meta'] ?? '') ?></div>
                  </div>
                  <div>
                    <form method="post" action="<?= base_url('admin/enroll') ?>">
                      <?= csrf_field() ?>
                      <input type="hidden" name="course_id" value="<?= (int)$c['id'] ?>">
                      <button class="btn-enroll" type="submit">Enroll</button>
                    </form>
                  </div>
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <div class="empty">No available courses right now.</div>
            <?php endif ?>
          </div>
        </div>

        <div style="height:14px"></div>

        <div class="panel-card">
          <div class="card-title">Quick Actions</div>
          <div class="quick-actions">
            <a class="btn-secondary" href="<?= base_url('my-courses') ?>">My Courses</a>
            <a class="btn-secondary" href="<?= base_url('assignments') ?>">Assignments</a>
            <a class="btn-secondary" href="<?= base_url('grades') ?>">Grades</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

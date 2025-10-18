<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Student';
$user_id = $_SESSION['user_id'] ?? 0;

require_once 'db.php'; // adjust if your DB connection file is different

// Fetch enrolled courses
$enrollments_query = $conn->query("
    SELECT e.course_id, c.title, e.enrollment_date 
    FROM enrollments e 
    JOIN courses c ON c.id = e.course_id 
    WHERE e.student_id = $user_id
");
$enrollments = $enrollments_query->fetch_all(MYSQLI_ASSOC);

// Fetch all available courses
$courses_query = $conn->query("SELECT * FROM courses");
$courses = $courses_query->fetch_all(MYSQLI_ASSOC);

// Notifications (sample)
$notifications = count($enrollments);

// CSRF Tokens (replace with your real CSRF generator if needed)
function csrf_token() { return 'csrf_token_name'; }
function csrf_hash() { return bin2hex(random_bytes(32)); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <meta name="csrf-hash" content="<?= csrf_hash() ?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #0a0f2c;
            color: #ffffff;
        }

        nav {
            background-color: #12193f;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h1 {
            margin: 0;
            font-size: 24px;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            border: 1px solid #fff;
            padding: 8px 16px;
            border-radius: 6px;
        }

        .dashboard-header {
            padding: 40px;
        }

        .cards {
            display: flex;
            gap: 20px;
            padding: 0 40px 40px;
            flex-wrap: wrap;
        }

        .card {
            background-color: #1c2541;
            border-radius: 12px;
            padding: 30px;
            flex: 1;
            min-width: 250px;
        }

        .tag {
            display: inline-block;
            padding: 3px 10px;
            font-size: 12px;
            border-radius: 12px;
            margin-left: 10px;
        }

        .courses-tag { background-color: #10b981; }
        .notif-tag { background-color: #3b82f6; }
        .profile-tag { background-color: #f59e0b; }

        h4 {
            margin-top: 30px;
            color: #3b82f6;
        }

        .list-group-item {
            background-color: #1c2541;
            color: #ffffff;
            border: none;
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: #3b82f6;
            border: none;
        }
    </style>
</head>
<body>

<nav>
    <h1>WebSystem</h1>
    <a href="logout.php">Logout</a>
</nav>

<div class="dashboard-header">
    <h2>Student Dashboard</h2>
    <p>Welcome back, <?= htmlspecialchars($username); ?>!</p>
</div>

<div class="cards">
    <div class="card">
        <h3>Enrolled Courses <span class="tag courses-tag">Courses</span></h3>
        <p><?= count($enrollments); ?></p>
    </div>
    <div class="card">
        <h3>Notifications <span class="tag notif-tag">New</span></h3>
        <p><?= $notifications; ?></p>
    </div>
    <div class="card">
        <h3>Profile Status <span class="tag profile-tag">Profile</span></h3>
        <p>Active</p>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h4>🎓 Enrolled Courses</h4>
            <div id="enrolled-list" class="list-group">
                <?php if (!empty($enrollments)): ?>
                    <?php foreach ($enrollments as $e): ?>
                        <div class="list-group-item" id="enrolled-item-<?= htmlspecialchars($e['course_id']) ?>">
                            <strong><?= htmlspecialchars($e['title']) ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($e['enrollment_date']) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-group-item">You are not enrolled in any courses yet.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <h4>📚 Available Courses</h4>
            <div id="available-list" class="list-group">
                <?php foreach ($courses as $c): ?>
                    <?php $isEnrolled = in_array($c['id'], array_column($enrollments ?? [], 'course_id')); ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center" id="course-row-<?= htmlspecialchars($c['id']) ?>">
                        <div>
                            <strong><?= htmlspecialchars($c['title']) ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($c['description']) ?></small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-primary enroll-btn" data-course-id="<?= htmlspecialchars($c['id']) ?>" <?= $isEnrolled ? 'disabled' : '' ?>>
                                <?= $isEnrolled ? 'Enrolled' : 'Enroll' ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="alert-placeholder" class="mt-3"></div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  var csrfName = $('meta[name="csrf-name"]').attr('content');
  var csrfHash = $('meta[name="csrf-hash"]').attr('content');

  $.ajaxSetup({
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  });

  $(document).on('click', '.enroll-btn', function(e){
    e.preventDefault();
    var btn = $(this);
    var courseId = btn.data('course-id');

    btn.prop('disabled', true).text('Processing...');

    var data = {};
    data['course_id'] = courseId;
    data[csrfName] = csrfHash;

    $.post('course_enroll.php', data)
      .done(function(res){
        if (res.status === 'success') {
          $('#alert-placeholder').html('<div class="alert alert-success">'+res.message+'</div>');
          btn.text('Enrolled').prop('disabled', true);
          var item = '<div class="list-group-item" id="enrolled-item-'+courseId+'"><strong>'+ res.data.course_title +'</strong><br><small class="text-muted">'+res.data.enrollment_date+'</small></div>';
          $('#enrolled-list').prepend(item);
        } else {
          $('#alert-placeholder').html('<div class="alert alert-danger">'+(res.message||'Enrollment failed')+'</div>');
          btn.prop('disabled', false).text('Enroll');
        }
      })
      .fail(function(){
        $('#alert-placeholder').html('<div class="alert alert-danger">An error occurred.</div>');
        btn.prop('disabled', false).text('Enroll');
      });
  });
});
</script>

</body>
</html>
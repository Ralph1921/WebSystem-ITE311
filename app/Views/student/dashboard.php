<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
        }
        .navbar {
            background-color: #1a1a2e;
            border-bottom: 1px solid #0f0f1d;
        }
        .navbar-brand, .nav-link {
            color: #e0e0e0 !important;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            background-color: #2a2a4a;
            border: 1px solid #3c3c6e;
            color: #e0e0e0;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #3c3c6e;
            border-bottom: 1px solid #5a5a8a;
            color: #ffffff;
        }
        .list-group-item {
            background-color: #2a2a4a;
            border-color: #3c3c6e;
            color: #e0e0e0;
        }
        .list-group-item:hover {
            background-color: #3c3c6e;
        }
        .course-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .enrolled-tag {
            background-color: #28a745;
            color: #ffffff;
            padding: .3em .6em;
            border-radius: .25rem;
            font-size: 0.8em;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 350px;
        }
        .alert-success {
            background-color: #28a745;
            color: #fff;
            border-color: #28a745;
        }
        .alert-danger {
            background-color: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }
        .alert-info {
            background-color: #17a2b8;
            color: #fff;
            border-color: #17a2b8;
        }
        .btn-close {
            filter: invert(1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">WebSystem</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/student/dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="alert-container"></div>

    <div class="container">
        <h1 class="mb-4">Student Dashboard</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        My Enrolled Courses
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="enrolledCoursesList">
                            <?php if (!empty($enrolledCourses)): ?>
                                <?php foreach ($enrolledCourses as $course): ?>
                                    <li class="list-group-item course-item" id="enrolled-<?= esc($course['id']) ?>">
                                        <div>
                                            <h5><?= esc($course['title']) ?></h5>
                                            <p class="text-muted mb-0"><?= esc($course['description']) ?></p>
                                        </div>
                                        <span class="enrolled-tag">Enrolled</span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted" id="noEnrolledCoursesMessage">You are not currently enrolled in any courses.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Available Courses
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="availableCoursesList">
                            <?php if (!empty($availableCourses)): ?>
                                <?php foreach ($availableCourses as $course): ?>
                                    <li class="list-group-item course-item" id="available-<?= esc($course['id']) ?>">
                                        <div>
                                            <h5><?= esc($course['title']) ?></h5>
                                            <p class="text-muted mb-0"><?= esc($course['description']) ?></p>
                                        </div>
                                        <button class="btn btn-primary btn-sm enroll-btn" data-course-id="<?= esc($course['id']) ?>"
                                                data-course-title="<?= esc($course['title']) ?>"
                                                data-course-description="<?= esc($course['description']) ?>">Enroll</button>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted" id="noAvailableCoursesMessage">No new courses available at the moment.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            function showAlert(message, type) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.alert-container').append(alertHtml);
                setTimeout(function() {
                    $('.alert-container .alert').last().alert('close');
                }, 5000);
            }

            $('#availableCoursesList').on('click', '.enroll-btn', function() {
                const $button = $(this);
                const courseId = $button.data('course-id');
                const courseTitle = $button.data('course-title');
                const courseDescription = $button.data('course-description');

                $button.prop('disabled', true).text('Enrolling...');

                $.ajax({
                    url: '<?= base_url('/course/enroll') ?>',
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({ course_id: courseId }),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert(response.message, 'success');

                            $button.closest('.list-group-item').fadeOut(300, function() {
                                $(this).remove();

                                if ($('#availableCoursesList .list-group-item').length === 0) {
                                    $('#availableCoursesList').append(
                                        '<li class="list-group-item text-muted" id="noAvailableCoursesMessage">No new courses available at the moment.</li>'
                                    );
                                }
                            });

                            const enrolledCourseHtml = `
                                <li class="list-group-item course-item" id="enrolled-${courseId}">
                                    <div>
                                        <h5>${courseTitle}</h5>
                                        <p class="text-muted mb-0">${courseDescription}</p>
                                    </div>
                                    <span class="enrolled-tag">Enrolled</span>
                                </li>
                            `;

                            $('#noEnrolledCoursesMessage').remove();
                            $('#enrolledCoursesList').append(enrolledCourseHtml);

                        } else if (response.status === 'info') {
                            showAlert(response.message, 'info');
                            $button.prop('disabled', false).text('Enroll');
                        } else {
                            showAlert('Error: ' + response.message, 'danger');
                            $button.prop('disabled', false).text('Enroll');
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error), 'danger');
                        console.error('AJAX Error:', status, error, xhr.responseText);
                        $button.prop('disabled', false).text('Enroll');
                    }
                });
            });
        });
    </script>
</body>
</html>
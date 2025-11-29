<?php include APPPATH . 'Views/templates/header.php'; ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="bi bi-book"></i> Available Courses</h2>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form id="searchForm" class="d-flex">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search courses..." name="search_term">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Courses Container -->
    <div id="coursesContainer" class="row">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card course-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text"><?= esc($course['description']) ?></p>
                            <a href="/courses/view/<?= $course['id'] ?>" class="btn btn-primary btn-sm">View Course</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- No Results Message -->
    <div id="noCoursesMessage" class="alert alert-info" style="display: none;">
        <i class="bi bi-info-circle"></i> No courses found matching your search.
    </div>
</div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Client-side filtering
        $('#searchInput').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            var courses = $('#coursesContainer .course-card');
            var visibleCount = 0;

            courses.each(function() {
                var courseName = $(this).find('.card-title').text().toLowerCase();
                var courseDescription = $(this).find('.card-text').text().toLowerCase();

                if (courseName.indexOf(searchTerm) > -1 || courseDescription.indexOf(searchTerm) > -1) {
                    $(this).closest('.col-md-4').show();
                    visibleCount++;
                } else {
                    $(this).closest('.col-md-4').hide();
                }
            });

            if (visibleCount === 0 && searchTerm !== '') {
                $('#noCoursesMessage').show();
            } else {
                $('#noCoursesMessage').hide();
            }
        });

        // Server-side search with AJAX
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            
            var searchTerm = $('#searchInput').val();

            $.post('<?= site_url('/courses/search') ?>', {
                search_term: searchTerm
            }, function(response) {
                if (response.success && response.data.length > 0) {
                    var courseHTML = '';
                    $.each(response.data, function(index, course) {
                        courseHTML += '<div class="col-md-4 mb-4">' +
                            '<div class="card course-card h-100">' +
                            '<div class="card-body">' +
                            '<h5 class="card-title">' + course.title + '</h5>' +
                            '<p class="card-text">' + course.description + '</p>' +
                            '<a href="/courses/view/' + course.id + '" class="btn btn-primary btn-sm">View Course</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    });

                    $('#coursesContainer').html(courseHTML);
                    $('#noCoursesMessage').hide();
                } else {
                    $('#coursesContainer').html('');
                    $('#noCoursesMessage').show();
                }
            }, 'json').fail(function(error) {
                console.error('Search failed:', error);
                $('#noCoursesMessage').show();
            });
        });
    });
</script>

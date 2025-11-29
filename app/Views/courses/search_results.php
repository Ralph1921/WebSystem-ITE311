<?php include APPPATH . 'Views/templates/header.php'; ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-search"></i> Search Results</h2>
            <?php if (!empty($searchTerm)): ?>
                <p class="text-muted">Results for: <strong><?= esc($searchTerm) ?></strong></p>
            <?php endif; ?>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= site_url('/courses') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Courses
            </a>
        </div>
    </div>

    <?php if (empty($courses)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No courses found matching your search criteria.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card course-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text"><?= esc($course['description']) ?></p>
                            <a href="/courses/view/<?= $course['id'] ?>" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>

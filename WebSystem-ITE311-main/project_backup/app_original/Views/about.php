<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <!-- Navigation Links -->
    <nav class="mb-4">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-primary me-2">Home</a>
        <a href="<?= base_url('/about') ?>" class="btn btn-primary me-2">About</a>
        <a href="<?= base_url('/contact') ?>" class="btn btn-outline-primary">Contact</a>
    </nav>

    <h1 class="mb-4"><?= $page_title ?></h1>
    <p><strong>Mission:</strong> <?= $mission ?></p>
    <p><strong>Vision:</strong> <?= $vision ?></p>

    <h3 class="mt-5">Our Team</h3>
    <div class="row">
        <?php foreach ($team as $member): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $member['name'] ?></h5>
                        <h6 class="text-muted"><?= $member['position'] ?></h6>
                        <p><?= $member['description'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

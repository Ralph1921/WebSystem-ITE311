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
        <a href="<?= base_url('/about') ?>" class="btn btn-outline-primary me-2">About</a>
        <a href="<?= base_url('/contact') ?>" class="btn btn-primary">Contact</a>
    </nav>

    <h1 class="mb-4"><?= $page_title ?></h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Email:</strong> <?= $contact_info['email'] ?></li>
        <li class="list-group-item"><strong>Phone:</strong> <?= $contact_info['phone'] ?></li>
        <li class="list-group-item"><strong>Address:</strong> <?= $contact_info['address'] ?></li>
        <li class="list-group-item"><strong>Business Hours:</strong> <?= $contact_info['hours'] ?></li>
    </ul>

</body>
</html>

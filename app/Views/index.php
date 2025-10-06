<?= $this->extend('layouts/main') ?>

<?= $this->section('navRight') ?>
    <a class="nav-link-top me-3" href="<?= base_url('/about') ?>">About</a>
    <a class="nav-link-top me-3" href="<?= base_url('/contact') ?>">Contact</a>
    <a class="nav-link-top me-3" href="<?= base_url('/login') ?>">Login</a>
    <a class="nav-link-top" href="<?= base_url('/register') ?>">Register</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-4">
    <div class="col-12 col-lg-10 col-xl-8">
        <div class="ui-card p-5 text-center">
            <h1 class="display-5 fw-bold mb-3">Welcome to My Homepage</h1>
            <p class="lead text-subtle mb-4">This is a CodeIgniter 4 Learning Management System</p>
            <p class="mb-4 text-subtle">Created by: TERRADO | ITE311 Student</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="<?= base_url('/about') ?>" class="btn btn-outline-light btn-lg px-4">Learn About Us</a>
                <a href="<?= base_url('/contact') ?>" class="btn btn-outline-light btn-lg px-4">Contact Us</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

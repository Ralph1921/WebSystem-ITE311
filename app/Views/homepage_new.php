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
            <h1 class="display-5 fw-bold mb-2">WELCOME</h1>
            <p class="lead text-subtle mb-4">
                Learning Management System - Your gateway to educational excellence. Access courses,
                track your progress, and enhance your learning experience.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="<?= base_url('/login') ?>" class="btn btn-gradient px-4 py-2">Login to Your Account</a>
                <a href="<?= base_url('/register') ?>" class="btn btn-outline-light px-4 py-2">Create New Account</a>
            </div>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <a href="<?= base_url('/about') ?>" class="btn btn-outline-light px-4 py-2">Learn About Us</a>
                <a href="<?= base_url('/contact') ?>" class="btn btn-outline-light px-4 py-2">Contact Us</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

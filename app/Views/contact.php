<?= $this->extend('layouts/main') ?>

<?= $this->section('navRight') ?>
    <a class="nav-link-top me-3" href="<?= base_url('/') ?>">Home</a>
    <a class="nav-link-top me-3" href="<?= base_url('/about') ?>">About</a>
    <a class="nav-link-top me-3" href="<?= base_url('/login') ?>">Login</a>
    <a class="nav-link-top" href="<?= base_url('/register') ?>">Register</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-4">
    <div class="col-12 col-lg-8">
        <div class="ui-card p-4 p-md-5">
            <h1 class="mb-3">Contact Us</h1>
            <div class="text-subtle mb-3"><strong>Email:</strong> support@example.com</div>
            <div class="text-subtle mb-3"><strong>Phone:</strong> (+63) 912-345-6789</div>
            <div class="text-subtle mb-3"><strong>Address:</strong> 123 Your Street, Your City, Philippines</div>
            <div class="text-subtle mb-0"><strong>Business Hours:</strong> Monday - Friday: 9:00 AM - 6:00 PM</div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

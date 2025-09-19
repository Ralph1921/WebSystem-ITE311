<?= $this->extend('layouts/main') ?>

<?= $this->section('head') ?>
<?php /** Additional per-page head content (optional) */ ?>
<?= $this->endSection() ?>

<?= $this->section('navRight') ?>
    <a class="nav-link-top me-3" href="<?= base_url('/') ?>">Home</a>
    <a class="nav-link-top me-3" href="<?= base_url('/contact') ?>">Contact</a>
    <a class="nav-link-top me-3" href="<?= base_url('/login') ?>">Login</a>
    <a class="nav-link-top" href="<?= base_url('/register') ?>">Register</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-4">
    <div class="col-12 col-lg-10">
        <div class="ui-card p-4 p-md-5">
            <h1 class="mb-2">About Us</h1>
            <p class="text-subtle mb-4">
                <strong>Mission:</strong> We strive to provide the best services to our customers and ensure satisfaction in every project we undertake.
            </p>
            <p class="text-subtle mb-4">
                <strong>Vision:</strong> Our team consists of dedicated professionals with expertise in various fields, working together to achieve excellence.
            </p>

            <h3 class="mt-2 mb-3">Our Team</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="ui-card p-4 h-100">
                        <h5 class="mb-1">Team Member</h5>
                        <div class="text-subtle mb-2">Position</div>
                        <p class="mb-0 text-subtle">Short description about the team member.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ui-card p-4 h-100">
                        <h5 class="mb-1">Team Member</h5>
                        <div class="text-subtle mb-2">Position</div>
                        <p class="mb-0 text-subtle">Short description about the team member.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ui-card p-4 h-100">
                        <h5 class="mb-1">Team Member</h5>
                        <div class="text-subtle mb-2">Position</div>
                        <p class="mb-0 text-subtle">Short description about the team member.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

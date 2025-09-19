<?= $this->extend('layouts/main') ?>

<?= $this->section('navRight') ?>
    <a class="nav-link-top" href="<?= base_url('/') ?>">Home</a>
    <a class="nav-link-top" href="<?= base_url('/about') ?>">About</a>
    <a class="nav-link-top" href="<?= base_url('/contact') ?>">Contact</a>
    <a class="btn btn-outline-primary btn-sm" href="<?= base_url('/logout') ?>">Logout</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="alert alert-info" role="alert">
    Welcome, <?= esc($user['email']) ?>!
</div>

<div class="alert alert-dark" role="alert">
    This is a protected page only visible after login.
</div>
<?= $this->endSection() ?>
<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h1 class="text-primary mb-4">Welcome to ITE311-MARAÑAN</h1>
            <p class="lead">Your Learning Management System</p>
            <p>This is the homepage content. Use the navigation above to access different sections.</p>
            
            
            <!--<?php if (!session()->get('isLoggedIn')): ?>
                <div class="mt-4">
                    <a href="<?= site_url('/register') ?>" class="btn btn-primary me-2">Get Started - Register</a>
                    <a href="<?= site_url('/login') ?>" class="btn btn-outline-primary">Login</a>
                </div>
            <?php else: ?>
                <div class="mt-4">
                    <h3>Welcome back, <?= session()->get('name') ?>!</h3>
                    <a href="<?= site_url('/dashboard') ?>" class="btn btn-success">Go to Dashboard</a>
                </div>
            <?php endif; ?>
            --->
        </div>
    </div>
</div>
<?= $this->endSection() ?>
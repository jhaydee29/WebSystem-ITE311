<?php $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-4 mb-4">Welcome, Admin!</h1>
                    <p class="lead">You are now logged in to the Admin Dashboard</p>
                    
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                        <h5>User Management</h5>
                                        <p>Manage system users and permissions</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-book fa-3x text-success mb-3"></i>
                                        <h5>Courses</h5>
                                        <p>Manage all courses and content</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                                        <h5>Analytics</h5>
                                        <p>View system statistics and reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-cog fa-3x text-warning mb-3"></i>
                                        <h5>Settings</h5>
                                        <p>Configure system settings</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="/announcements" class="btn btn-primary me-2">
                            <i class="fas fa-bullhorn me-1"></i> Manage Announcements
                        </a>
                        <a href="/admin/users" class="btn btn-outline-primary me-2">
                            <i class="fas fa-users-cog me-1"></i> Manage Users
                        </a>
                        <a href="/logout" class="btn btn-outline-secondary">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

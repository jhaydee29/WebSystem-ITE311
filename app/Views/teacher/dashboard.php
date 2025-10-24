<?php $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-4 mb-4">Welcome, Teacher!</h1>
                    <p class="lead">You are now logged in to the Teacher Dashboard</p>
                    
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                                        <h5>My Courses</h5>
                                        <p>Manage your courses and teaching materials</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-tasks fa-3x text-success mb-3"></i>
                                        <h5>Assignments</h5>
                                        <p>Create and grade student assignments</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                                        <h5>Students</h5>
                                        <p>View and manage your students</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4
                    ">
                        <a href="/announcements" class="btn btn-primary me-2">
                            <i class="fas fa-bullhorn me-1"></i> View Announcements
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

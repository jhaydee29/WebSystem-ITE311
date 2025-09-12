<?= $this->extend('dashboard_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Total Courses: 12</h5>
                <h5>Completed: 8</h5>
                <h5>In Progress: 3</h5>
                <h5>Assignments: 5</h5>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Recent Activity</h5>
                <ul>
                    <li>Completed Assignment: Database Design</li>
                    <li>Started Course: Web Development</li>
                    <li>Quiz Submitted: PHP Fundamentals</li>
                    <li>Joined Discussion: MVC Architecture</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
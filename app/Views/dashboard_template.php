<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSystem - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">ITE311-MARAÑAN Dashboard</a>
        <div class="navbar-nav ms-auto">
            <span class="navbar-text me-3">Welcome, <?= session()->get('name') ?>!</span>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

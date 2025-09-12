<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container position-relative">
    <a class="navbar-brand position-absolute start-50 translate-middle-x" href="#">ITE311-MARAÑAN</a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('/') ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('/about') ?>">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('/contact') ?>">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5 text-center">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
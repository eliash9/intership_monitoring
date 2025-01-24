
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring App</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/style.css"> <!-- Tambahkan jika ada custom CSS -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index">Monitoring App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                $baseurl = "/intership_monitoring";
                $pages = [
                    'Home' => '/index',
                    'Data Siswa' => '/pages/students',
                    'Data Guru' => '/pages/teachers',
                    'Data Perusahaan' => '/pages/companies',
                    'Periode'=>'/pages/periode',
                    'Intership'=>'/pages/intership',
                    'Jadwal Monitoring' => '/pages/monitoring'
                ];
                foreach ($pages as $label => $url): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseurl.$url ?>"><?= $label ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">

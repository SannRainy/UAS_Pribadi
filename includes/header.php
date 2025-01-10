<?php
session_start();
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}

if (!isset($_SESSION["username"])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/5hb7xvEv+MCeI6UJIFK7/sy6Te/XImsaGoAX1Y" crossorigin="anonymous">
    <title>Web Pribadi</title>
</head>
<body>
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent position-absolute w-100" style="top: 0;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Gallery Of Art</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item"><a class="nav-link text-white" href="../home.php"><strong>Home</strong></a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../gallery.php"><strong>Gallery</strong></a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../upload.php"><strong>Upload</strong></a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../profile.php"><strong>Gallery Management</strong></a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../contactus.php"><strong>Contact Us</strong></a></li>
                    <li class="nav-item">
                        <form action="home.php" method="POST">
                            <button type="submit" name="logout" class="btn custom-logout-btn"><strong>Logout</strong></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Background Video with Text -->
    <div class="bg-img" style="position: relative; width: 100%; height: 100vh; overflow: hidden;">
    <video autoplay muted loop class="video-background" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 0; filter: grayscale(100%);">
        <source src="asset/video/bocchi-the-rock-chibi-moewalls-com.mp4" type="video/mp4">
    </video>
    <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(107, 104, 104, 0.5); z-index: 1;"></div>
</div>

    <div class="text-overlay">
        <p>ART COLLECTION</p>
        <h1>Selamat Datang di Dashboard @<?= $_SESSION["username"] ?></h1>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

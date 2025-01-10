<?php
include 'includes/header.php'; // Include header.php
include 'includes/db.php';

// Database connection
$pdo = pdo_connect_mysql();
$stmt = $pdo->query('SELECT * FROM images ORDER BY uploaded_on DESC');
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/style/gallery.css">
    <link rel="stylesheet" href="asset/style/global.css">
    <script src="js/gallery.js"></script>
    <title>Gallery</title>
</head>
<body>
    <main>
        <section class="gallery-section">
            <h1 class="text-center my-5">Image Gallery</h1>

            <!-- Image Grid -->
            <div class="grid-container">
                <?php foreach ($images as $image): ?>
                    <div class="grid-item">
                        <div class="Img-container">
                            <img src="asset/img/<?php echo htmlspecialchars($image['file_name']); ?>" alt="<?php echo htmlspecialchars($image['description']); ?>">
                        </div>
                        <div class="image-description">
                            <?php echo htmlspecialchars($image['description']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Upload and Reload Buttons -->
            <div class="text-center mt-4">
    <a href="upload.php" class="btn btn-primary">Upload New Image</a>
    <!--<button onclick="loadImages()" class="btn btn-secondary">Reload Halaman</button>-->
</div>

        </section>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
    </main>
</body>
</html>



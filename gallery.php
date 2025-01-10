<?php
include 'includes/header.php'; // Include header.php
include 'includes/db.php';

// Database connection
$pdo = pdo_connect_mysql();

// Handle search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search_query)) {
    $stmt = $pdo->prepare('SELECT * FROM images WHERE description LIKE ? ORDER BY uploaded_on DESC');
    $stmt->execute(['%' . $search_query . '%']);
} else {
    $stmt = $pdo->query('SELECT * FROM images ORDER BY uploaded_on DESC');
}

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="js/gallery.js"></script>
    <title>Gallery</title>
</head>
<body>
    <main>
        <section class="gallery-section">
            <h1 class="text-center my-5 text-shadow">Image Gallery</h1>

            <!-- Search Bar -->
            <div class="container mb-4">
                <form method="GET" action="" class="d-flex justify-content-center">
                    <input type="text" name="search" class="form-control w-50 me-2" placeholder="Search images..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <!-- Image Grid -->
            <div class="grid-container">
                <?php if (count($images) > 0): ?>
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
                <?php else: ?>
                    <p class="text-center">No images found for "<?php echo htmlspecialchars($search_query); ?>".</p>
                <?php endif; ?>
            </div>

            <!-- Upload Button -->
            <div class="text-center mt-4">
                <a href="upload.php" class="btn btn-primary">Upload New Image</a>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800, // Durasi animasi
                once: true,    // Animasi hanya berjalan sekali
            });
        </script>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
    </main>
</body>
</html>

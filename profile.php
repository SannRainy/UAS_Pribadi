<?php include 'includes/header.php'; ?>
<?php
// Database connection
require_once 'includes/db.php';
$pdo = pdo_connect_mysql();

// Delete image if delete request is sent
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT file_name FROM images WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetch();

    if ($image) {
        $filePath = "asset/img/" . $image['file_name'];
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }
        $stmt = $pdo->prepare("DELETE FROM images WHERE id = ?");
        $stmt->execute([$id]);
        echo "<div class='alert alert-success'>Image deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Image not found.</div>";
    }
}

// Fetch all images from database
$stmt = $pdo->query("SELECT * FROM images");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/style/profile.css">
    <link rel="stylesheet" href="asset/style/global.css">
    <title>Image Management</title>
</head>
<body>
    <div class="gallery-section">
        <h1 class= "text-center my-5 text-shadow ">Image Management</h1>
        <div class="image-grid">
            <?php foreach ($images as $image): ?>
                <div class="image-card">
                    <img src="asset/img/<?= htmlspecialchars($image['file_name']) ?>" alt="Image">
                    <div class="card-body">
                        <p class="image-description"><?= htmlspecialchars($image['description']) ?></p>
                        <a href="?delete=<?= htmlspecialchars($image['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this image?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>

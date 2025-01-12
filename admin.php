<?php
include 'includes/db.php';

// Check if admin is logged in
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["is_admin"])) {
    header("Location: index.php");
    exit();
}

$pdo = pdo_connect_mysql();
$message = "";

// Handle image management
if (isset($_POST['delete_image'])) {
    $image_id = $_POST['image_id'];
    $stmt = $pdo->prepare("DELETE FROM images WHERE id = ?");
    if ($stmt->execute([$image_id])) {
        $message = "Image deleted successfully.";
    } else {
        $message = "Failed to delete image.";
    }
}

// Handle image edit
if (isset($_POST['edit_image'])) {
    $image_id = $_POST['image_id'];
    $description = $_POST['description'];
    $new_file_name = $_FILES['new_image']['name'] ?? null;

    if ($new_file_name) {
        $targetDir = "asset/img/";
        $targetFilePath = $targetDir . $new_file_name;
        if (move_uploaded_file($_FILES['new_image']['tmp_name'], $targetFilePath)) {
            $stmt = $pdo->prepare("UPDATE images SET file_name = ?, description = ? WHERE id = ?");
            $stmt->execute([$new_file_name, $description, $image_id]);
            $message = "Image updated successfully.";
        } else {
            $message = "Failed to upload new image.";
        }
    } else {
        $stmt = $pdo->prepare("UPDATE images SET description = ? WHERE id = ?");
        if ($stmt->execute([$description, $image_id])) {
            $message = "Image description updated successfully.";
        } else {
            $message = "Failed to update image.";
        }
    }
}

// Fetch images
$stmt = $pdo->query("SELECT * FROM images ORDER BY uploaded_on DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch contact messages
$stmt = $pdo->query("SELECT * FROM Contact ORDER BY id DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body>
<div class="container mt-5">
    <!-- Profile Section -->
    <div class="card shadow-lg mb-5">
        <div class="card-body text-center">
            <img src="asset/img/MM-3MM3 '036.JPG" class="rounded-circle mb-3" alt="Profile Image" width="150">
            <h3>Krisna Satya Arisandy</h3>
            <p>Owner | Digital Artist</p>
            <p>Email: <a href="mailto:krisnasatyaarisandy@gmail.com">krisnasatyaarisandy@gmail.com</a></p>
            <p>Phone: +62 857-5583-6281</p>
            <p>Location: Jakarta, Indonesia</p>
        </div>
    </div>

    <!-- Image Management Section -->
    <div class="card shadow-lg mb-5">
        <div class="card-body">
            <h3 class="mb-4">Manage Gallery Images</h3>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($images as $image): ?>
                    <tr>
                        <td><img src="asset/img/<?= htmlspecialchars($image['file_name']) ?>" alt="<?= htmlspecialchars($image['description']) ?>" width="100"></td>
                        <td><?= htmlspecialchars($image['description']) ?></td>
                        <td>
                            <!-- Delete Button -->
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                                <button type="submit" name="delete_image" class="btn btn-danger btn-sm">Delete</button>
                            </form>

                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $image['id'] ?>">Edit</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $image['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $image['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?= $image['id'] ?>">Edit Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                                        <div class="mb-3">
                                            <label for="description<?= $image['id'] ?>" class="form-label">Description:</label>
                                            <input type="text" id="description<?= $image['id'] ?>" name="description" value="<?= htmlspecialchars($image['description']) ?>" required class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_image<?= $image['id'] ?>" class="form-label">Change Image (optional):</label>
                                            <input type="file" id="new_image<?= $image['id'] ?>" name="new_image" accept="image/*" class="form-control">
                                        </div>
                                        <button type="submit" name="edit_image" class="btn btn-success w-100">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Message Management Section -->
    <div class="card shadow-lg">
        <div class="card-body">
            <h3 class="mb-4">Manage Messages</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Contact</th>
                    <th>Message</th>
                    <th>Reply</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['username']) ?></td>
                        <td><?= htmlspecialchars($contact['contact']) ?></td>
                        <td><?= htmlspecialchars($contact['message']) ?></td>
                        <td><?= htmlspecialchars($contact['reply'] ?? 'N/A') ?></td>
                        <td>
                            <form method="POST" class="d-flex">
                                <input type="hidden" name="contact_id" value="<?= $contact['id'] ?>">
                                <input type="text" name="reply" class="form-control form-control-sm me-2" placeholder="Type reply...">
                                <button type="submit" name="reply_message" class="btn btn-primary btn-sm">Reply</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

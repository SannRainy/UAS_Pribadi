<?php include 'includes/header.php'; ?>
<?php
// upload_process.php
require_once 'includes/db.php';

if (isset($_POST["submit"])) {
    if (!empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetDir = "asset/img/";
        $targetFilePath = $targetDir . $fileName;

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'mp4', 'avi', 'mov', 'wmv');
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $description = $_POST['description'];
                $pdo = pdo_connect_mysql();
                $stmt = $pdo->prepare("INSERT INTO images (file_name, description) VALUES (?, ?)");
                if ($stmt->execute([$fileName, $description])) {
                    echo "The file " . htmlspecialchars($fileName) . " has been uploaded successfully.";
                } else {
                    echo "File upload failed, please try again.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo 'Sorry, only JPG, JPEG, PNG, GIF, and video files are allowed to upload.';
        }
    } else {
        echo 'Please select a file to upload.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="asset/style/upload.css">
    <link rel="stylesheet" href="asset/style/global.css">
    <title>Upload and Edit</title>
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Upload Your Image</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="image" class="form-label">Choose an image:</label>
                <input type="file" id="image" name="image" accept="image/*" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input type="text" id="description" name="description" placeholder="Enter a description" required class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Upload</button>
        </form>

        <h2 class="text-center my-4">Manage Uploaded Images</h2>
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pdo = pdo_connect_mysql();
                $stmt = $pdo->query("SELECT * FROM images ORDER BY uploaded_on DESC");
                $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($images as $index => $image) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><img src="asset/img/<?php echo htmlspecialchars($image['file_name']); ?>" alt="" class="img-thumbnail" style="max-width: 100px;"></td>
                        <td><?php echo htmlspecialchars($image['description']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $image['id']; ?>">Edit</button>
                            
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $image['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $image['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?php echo $image['id']; ?>">Edit Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="edit_process.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                                        <div class="mb-3">
                                            <label for="description<?php echo $image['id']; ?>" class="form-label">Description:</label>
                                            <input type="text" id="description<?php echo $image['id']; ?>" name="description" value="<?php echo htmlspecialchars($image['description']); ?>" required class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_image<?php echo $image['id']; ?>" class="form-label">Change Image (optional):</label>
                                            <input type="file" id="new_image<?php echo $image['id']; ?>" name="new_image" accept="image/*" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<?php include 'includes/footer.php'; ?>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>

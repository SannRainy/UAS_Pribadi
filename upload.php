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
                $stmt = $pdo->prepare(query: "INSERT INTO images (file_name, description) VALUES (?, ?)");
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
    <link rel="stylesheet" href="asset/style/upload.css">
    <link rel="stylesheet" href="asset/style/style.css">
    <script src="js/upload.js"></script>
    <title>Upload Image</title>
</head>
<body>
    <div class="upload-container">
        <h1>Upload Your Image</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="image">Choose an image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" placeholder="Enter a description" required>
    </div>
    <button type="submit" name="submit" class="upload-button">Upload</button>
</form>
        <div class="preview">
            <h2>Preview</h2>
            <img id="preview-image" src="#" alt="Image Preview" style="display:none;">
        </div>
    </div>

    <script>

        document.getElementById('image').onchange = function (event) {
            const preview = document.getElementById('preview-image');
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
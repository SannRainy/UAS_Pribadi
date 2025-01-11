<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $description = $_POST['description'];

    $pdo = pdo_connect_mysql();

    // Cek apakah gambar baru diunggah
    if (!empty($_FILES["new_image"]["name"])) {
        $fileName = basename($_FILES["new_image"]["name"]);
        $targetDir = "asset/img/";
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $targetFilePath)) {
                // Update gambar dan deskripsi
                $stmt = $pdo->prepare("UPDATE images SET file_name = ?, description = ? WHERE id = ?");
                $stmt->execute([$fileName, $description, $id]);
            }
        }
    } else {
        // Hanya update deskripsi jika tidak ada gambar baru
        $stmt = $pdo->prepare("UPDATE images SET description = ? WHERE id = ?");
        $stmt->execute([$description, $id]);
    }

    header('Location: upload.php');
    exit;
}
?>

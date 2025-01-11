<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $description = $_POST['description'];

    $pdo = pdo_connect_mysql();
    $stmt = $pdo->prepare("UPDATE images SET description = ? WHERE id = ?");
    $stmt->execute([$description, $id]);

    header('Location: upload.php');
    exit;
}
?>

<?php
include 'includes/db.php';

$imagesPerPage = 10;

// Dapatkan halaman yang diinginkan dari query string, default ke 1 jika tidak ada
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Hitung offset untuk pagination
$offset = ($page - 1) * $imagesPerPage;

// Query untuk mengambil gambar dari database dengan pagination
$stmt = $pdo->prepare('SELECT * FROM images ORDER BY uploaded_on DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $imagesPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Ambil hasil query
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Persiapkan respons JSON
$response = [
    'images' => [],
    'current_page' => $page,
    'images_per_page' => $imagesPerPage
];

// Masukkan data gambar ke dalam array respons
foreach ($images as $image) {
    $response['images'][] = [
        'src' => 'asset/img/' . htmlspecialchars($image['file_name']),
        'title' => htmlspecialchars($image['description']),
    ];
}

// Set header untuk mengirimkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

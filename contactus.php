<?php include 'includes/header.php'; ?>
<?php
include 'includes/db.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = "";
$success = "";

if (!isset($_SESSION["is_login"])) {
    header("Location: contactus.php");
    exit();
}

if (isset($_POST['submit'])) {
    $contact = $_POST['contact'];
    $message = $_POST['message'];
    $username = $_SESSION['username'];

    $pdo = pdo_connect_mysql();

    if (empty($message)) {
        $error = "Message field cannot be empty.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $stmt = $pdo->prepare("INSERT INTO Contact (username, contact, message) VALUES (:username, :contact, :message)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':message', $message);

                if ($stmt->execute()) {
                    $success = "Message sent successfully!";
                } else {
                    $error = "Failed to send message. Please try again.";
                }
            } else {
                $error = "User not found.";
            }
        } catch (PDOException $e) {
            $error = "Database query failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/style/contactus.css">
    <link rel="stylesheet" href="asset/style/global.css">
    <title>Contact Us</title>
</head>
<body>
<div class="container mt-5">
    <!-- Profile Card -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <a href="profile.php">
                    <img src="asset/img/KFK.jpg" class="card-img-top rounded" alt="Profile Image">
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">Krisna Satya Arisandy</h5>
                    <p class="card-text">Owner</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Profile Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-16">
            <div class="p-4 rounded" style="background-color: #2c3e50; color: white;">
                <h3 class="text-uppercase text-warning">Professional Profile</h3>
                <h2 class="mb-3">Krisna Satya Arisandy</h2>
                <p><strong>Job Title:</strong> Owner</p>
                <p><strong>Email:</strong> krisnasatyaarisandy@gmail.com</p>
                <p><strong>Phone:</strong> +62 857-5583-6281</p>
                <p><strong>LinkedIn:</strong> <a href="www.linkedin.com/in/ksarain17" class="text-warning">linkedin.com/in/krisnasatyaarisandy</a></p>
                <p><strong>Skills:</strong></p>
                <ul style="list-style-type: disc; padding-left: 20px;">
                    <li>Digital Painting</li>
                    <li>Profesional Artist</li>
                    <li>etc</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row justify-content-center">
        <div class="col-md-16">
            <div class="p-4 shadow-lg rounded bg-white">
                <h3 class="text-center text-dark mb-4">Leave a Message</h3>

                <!-- Error and Success Messages -->
                <?php if ($error): ?>
                    <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="InputContact" class="form-label">Contact</label>
                        <input type="text" class="form-control" name="contact" id="InputContact" placeholder="08**********">
                    </div>
                    <div class="mb-3">
                        <label for="Textarea" class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="Textarea" rows="4" required></textarea>
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="submit" class="btn btn-primary w-100">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>

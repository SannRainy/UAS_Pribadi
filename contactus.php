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

<div class="container container-fluid d-flex flex-column align-items-center">
    <!-- Title Text -->
    
    <!-- Single Card Container -->
    <div class="Card-container container-fluid d-flex justify-content-center align-items-center" style="padding-top: 5rem;">
        <div class="card" 
             style="width: 15rem; height: auto; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border: 1px solid #ccc; border-radius: 5px; padding: 1rem; background-color: #f8f9fa;">
            <!-- Profile Image -->
            <img src="asset/img/satya.gif" 
                 alt="Profile Image" 
                 style="width: 100%; height: auto; max-height: 200px; object-fit: cover; border-radius: 50%; margin-bottom: 1rem;">
            
            <!-- Profile Details -->
            <div class="card-body" style="text-align: center; padding: 1rem;">
                <h5 class="card-title" style="font-weight: bold;">Krisna Satya Arisandy</h5>
                <p class="card-text text-muted">Owner | Digital Artist</p>
                <!-- LinkedIn Button -->
                <div class="d-flex justify-content-center mb-3">
                    <a href="https://www.linkedin.com/in/ksarain17" 
                       class="btn btn-warning btn-sm" 
                       target="_blank" 
                       style="font-size: 0.85rem;">
                        <i class="bi bi-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Professional Profile Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="p-4 rounded shadow-lg" style="background-color: #34495e; color: white;">
                <h3 class="text-uppercase text-warning text-center mb-4">Professional Profile</h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="text-light">Personal Information</h5>
                        <p><strong>Job Title:</strong> Owner</p>
                        <p><strong>Email:</strong> <a href="mailto:krisnasatyaarisandy@gmail.com" class="text-warning">krisnasatyaarisandy@gmail.com</a></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-light">Contact</h5>
                        <p><strong>Phone:</strong> +62 857-5583-6281</p>
                        <p><strong>Location:</strong> Jakarta, Indonesia</p>
                    </div>
                </div>

                <hr class="my-4" style="border-color: #ecf0f1;">

                <!-- Skills Section -->
                <h5 class="text-light">Skills</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-warning"></i> Digital Painting</li>
                    <li><i class="bi bi-check-circle-fill text-warning"></i> Professional Artist</li>
                    <li><i class="bi bi-check-circle-fill text-warning"></i> Graphic Design & Illustration</li>
                    <li><i class="bi bi-check-circle-fill text-warning"></i> Branding & Visual Identity</li>
                    <li><i class="bi bi-check-circle-fill text-warning"></i> Concept Art & Storyboarding</li>
                </ul>

                <!-- About Me Section -->
                <div class="mt-4">
                    <h5 class="text-light">About Me</h5>
                    <p id="bio" class="collapse">
                        I am a passionate digital artist with over 10 years of experience creating stunning visual art, including digital paintings, concept art, and branding designs. My journey started with traditional art, but I transitioned into digital art as technology evolved, and it has since become my primary medium. I continue to explore new techniques and push the boundaries of my craft.
                    </p>
                    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#bio" aria-expanded="false" aria-controls="bio">
                        <i class="bi bi-arrow-down-circle"></i> Read More
                    </button>
                </div>

                <hr class="my-4" style="border-color: #ecf0f1;">

                <!-- Achievements Section -->
                <h5 class="text-light">Achievements</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="achievement-box">
                            <h4 class="text-warning">500+</h4>
                            <p>Digital Paintings Completed</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="achievement-box">
                            <h4 class="text-warning">10+</h4>
                            <p>Years of Experience</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="achievement-box">
                            <h4 class="text-warning">100+</h4>
                            <p>Happy Clients</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Contact Form -->
    <div class="row justify-content-center">
        <div class="col-md-10">
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

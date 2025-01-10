<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="asset/style/profile.css">
<link rel="stylesheet" href="asset/style/style.css">
<script src="js/script.js"></script>

<div class="container mt-5">
    <!-- Profile Header Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 text-center rounded">
                <a href="profile.php">
                    <img src="asset/img/KFK.jpg" class="card-img-top rounded-circle" alt="Profile Image">
                </a>
                <div class="card-body">
                    <h5 class="card-title text-primary">Krisna Satya Arisandy</h5>
                    <p class="card-text text-muted">Owner | Digital Artist</p>
                    <div class="d-flex justify-content-center">
                        <a href="https://www.linkedin.com/in/ksarain17" class="btn btn-warning btn-sm" target="_blank">
                            <i class="bi bi-linkedin"></i> LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Profile Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-16">
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

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional JS for Smooth Scroll for Skills Section -->
<script>
    document.querySelector('.skills-link').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#skills-section').scrollIntoView({
            behavior: 'smooth'
        });
    });
</script>


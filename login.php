<?php
include 'includes/db.php';
session_start();

$login_message = "";
if (isset($_SESSION["is_login"])) {
    header("location: home.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = pdo_connect_mysql();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($password === $user['password']) {
            $_SESSION["username"] = $user["username"];
            $_SESSION["is_login"] = true;

            // Check if the username is "admin"
            if ($username === "admin") {
                $_SESSION["is_admin"] = true; // Set a session for admin
                header("location: admin.php");
            } else {
                header("location: home.php");
            }
            exit();
        } else {
            $login_message = "Password salah.";
        }
    } else {
        $login_message = "Akun tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="asset/style/login.css">
</head>
<body>
    <div class="login-container">
        <h3>Login Akun</h3>
        <?php if ($login_message): ?>
            <div class="alert"><?= htmlspecialchars($login_message) ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" placeholder="Username" name="username" required />
            <input type="password" placeholder="Password" name="password" required />
            <button type="submit" name="login">Masuk sekarang</button>
        </form>
    </div>
    <div class="button-container">
        <a href="register.php" class="button">Kembali ke registrasi</a>
    </div>
</body>
</html>
<?php include 'includes/footer.php'; ?>

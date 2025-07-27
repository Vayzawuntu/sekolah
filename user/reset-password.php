<?php
session_start();
if (!isset($_SESSION['sslogin'])) {
    header("location:../auth/login.php");
    exit();
}

require_once '../config.php';

$msg = '';

if (isset($_POST['reset'])) {
    $username = htmlspecialchars($_POST['username']);
    $newPass = htmlspecialchars($_POST['newPass']);

    $queryUser = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");
    
    if (mysqli_num_rows($queryUser) == 0) {
        $msg = "Username tidak ditemukan!";
    } else {
        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE tbl_user SET password = '$hashedPass' WHERE username = '$username'");
        $msg = "Password berhasil direset!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h3>Reset Password User</h3>
    <?php if ($msg) : ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" required class="form-control">
        </div>
        <div class="mb-3">
            <label for="newPass" class="form-label">Password Baru</label>
            <input type="text" name="newPass" required class="form-control">
        </div>
        <button type="submit" name="reset" class="btn btn-primary">Reset Password</button>
    </form>
</body>
</html>

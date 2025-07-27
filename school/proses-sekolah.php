<?php
session_start();
require_once "../config.php";

// Cek jika form login dikirim
if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $role     = htmlspecialchars($_POST['role']);

    // Ambil data user berdasarkan username
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");

    if ($query && mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

        // Cek password (plaintext; nanti bisa diganti pakai password_hash)
        if ($password === $user['password']) {
            if ($role === strtolower($user['jabatan'])) {

                // Set session login
                $_SESSION['ssLogin']   = true;
                $_SESSION['ssUser']    = $username;
                $_SESSION['ssNama']    = $user['nama'];
                $_SESSION['ssJabatan'] = $user['jabatan'];

                // Redirect sesuai role
                switch ($role) {
                    case 'admin':
                        header("Location: ../index.php");
                        break;
                    case 'guru':
                        header("Location: ../guru/");
                        break;
                    case 'siswa':
                        header("Location: ../siswa/");
                        break;
                    case 'ortu':
                        header("Location: ../ortu/");
                        break;
                    default:
                        header("Location: ../index.php");
                        break;
                }
                exit;

            } else {
                echo "<script>alert('Role tidak sesuai.'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('Password salah.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan.'); window.location.href='login.php';</script>";
    }
} else {
    // Akses langsung ke file tanpa klik login
    header("Location: login.php");
    exit;
}

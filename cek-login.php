<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Fungsi untuk membatasi akses halaman berdasarkan role
 * @param string $role_diizinkan
 */
function hanya_akses($role_diizinkan) {
    if (!isset($_SESSION['ssLogin'])) {
        header("Location: ../auth/login.php");
        exit;
    }

    // Role dalam database dan sesi disamakan huruf kecil
    if (strtolower($_SESSION['ssJabatan']) !== strtolower($role_diizinkan)) {
        echo "<script>
                alert('Akses ditolak! Halaman ini hanya untuk " . ucfirst($role_diizinkan) . "!');
                window.location.href = '../index.php';
              </script>";
        exit;
    }
}

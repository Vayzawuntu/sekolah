<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit();
}

require_once '../config.php';

if (isset($_POST['simpan'])) {
    $curPass = htmlspecialchars($_POST['curPass']);
    $newPass = htmlspecialchars($_POST['newPass']);
    $confPass = htmlspecialchars($_POST['confPass']);

    // Ambil username dari session
    $userName = $_SESSION['ssLogin']['username'];

    // Query ke tabel yang benar: tbl_user
    $queryUser = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$userName'");

    // Cek jika query gagal
    if (!$queryUser) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_array($queryUser);

    // Untuk sementara, jika password belum di-hash, bandingkan biasa
    // Gantilah ini jika nanti semua password sudah di-hash
    if ($newPass != $confPass) {
        header("location:password.php?msg=err1");
        exit();
    }

 if (!password_verify($curPass, $data['password'])) {

        header("location:password.php?msg=err2");
        exit();
    }

    // Simpan password baru (optional: hash jika ingin lebih aman)
    $passBaru = password_hash($newPass, PASSWORD_DEFAULT); // direkomendasikan pakai hash
    mysqli_query($koneksi, "UPDATE tbl_user SET password = '$passBaru' WHERE username = '$userName'");

    header("location:password.php?msg=updated");
    exit();
}

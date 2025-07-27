<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}

require_once "../config.php"; // sudah termasuk fungsi uploading()

if (isset($_POST['simpan'])) {
    $username = trim(htmlspecialchars($_POST['username']));
    $nama = trim(htmlspecialchars($_POST['nama']));
    $jabatan = $_POST['jabatan'];
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $password = 1234;
    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $gambar = $_FILES['image']['name'] ?? '';

    $cek = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        header("location:add-user.php?msg=cancel");
        exit;
    }

    if (!empty($gambar)) {
        $gambar = uploading('add-user.php');
    } else {
        $gambar = 'toga.png';
    }

    mysqli_query($koneksi, "INSERT INTO tbl_user (username, password, nama, alamat, jabatan, foto) 
        VALUES ('$username', '$passHash', '$nama', '$alamat', '$jabatan', '$gambar')");

    header("location:add-user.php?msg=added");
    exit;
}

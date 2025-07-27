<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config.php';
if (isset($_POST['simpan'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $telpon = htmlspecialchars($_POST['telpon']);
    $agama = $_POST['agama'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $foto = htmlspecialchars($_POST['image']['name']);

    $cekNip = mysqli_query($koneksi, "SELECT nip FROM tbl_guru WHERE nip = '$nip'");

    if (mysqli_num_rows($cekNip) > 0) {
        header('location:add-guru.php?msg=cancel');
        return;
    }
}
 if ($foto != null) {
        $url = "add-guru.php";
        $foto = uploading($url);
    } else {
        $foto = "default.png";
    }

    mysqli_query($koneksi, "INSERT INTO tbl_guru VALUES (null, '$nip', '$nama', '$alamat', '$telpon', '$agama', '$foto')");

    header("location:add-guru.php?msg=added");
    return;

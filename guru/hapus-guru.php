<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit();
}

require_once '../config.php';

$id = intval($_GET['id'] ?? 0);
$foto = $_GET['foto'] ?? '';

// Cari data guru dulu (untuk ambil nama foto yang valid)
$query = mysqli_query($koneksi, "SELECT foto FROM tbl_guru WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if ($data) {
    $fotoGuru = $data['foto'];

    // Hapus data guru
    mysqli_query($koneksi, "DELETE FROM tbl_guru WHERE id = $id");

    // Hapus file jika bukan default
    if (!empty($fotoGuru) && $fotoGuru != 'user.png' && file_exists("../../asset/image/" . $fotoGuru)) {
        unlink("../../asset/image/" . $fotoGuru);
    }

    header("location:guru.php?msg=deleted");
} else {
    header("location:guru.php?msg=notfound");
}
?>

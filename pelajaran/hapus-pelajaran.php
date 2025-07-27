<?php
session_start();
if (!isset($_SESSION['ssLogin']) || $_SESSION['ssJabatan'] !== 'admin') {
    die("Akses ditolak.");
}

require_once '../config.php';

if (!isset($_GET['id'])) {
    header("Location: pelajaran.php?msg=notfound");
    exit();
}

$id = $_GET['id'];
$delete = mysqli_query($koneksi, "DELETE FROM tbl_pelajaran WHERE id = $id");

header("Location: pelajaran.php?msg=" . ($delete ? "deleted" : "error"));
exit();
?>

<?php
require_once "../config.php";
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM tbl_ujian WHERE no_ujian = $id");

if ($hapus) {
    header("Location: index.php?msg=deleted");
    exit;
} else {
    echo "Gagal menghapus: " . mysqli_error($koneksi);
}

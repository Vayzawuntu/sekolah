<?php
session_start();

// Hanya admin yang bisa hapus data
if (!isset($_SESSION['ssLogin']) || $_SESSION['ssJabatan'] !== 'admin') {
    die("Akses ditolak.");
}

require_once '../config.php';

if (isset($_GET['nis']) && isset($_GET['foto'])) {
    $nis  = mysqli_real_escape_string($koneksi, $_GET['nis']);
    $foto = basename($_GET['foto']); // basename mencegah path traversal (misal ../../)

    // Pastikan file yang akan dihapus bukan file default
    if ($foto !== 'default.png') {
        $pathFoto = "../asset/image/" . $foto;
        if (file_exists($pathFoto)) {
            unlink($pathFoto);
        }
    }

    // Hapus data dari database
    $hapus = mysqli_query($koneksi, "DELETE FROM tbl_siswa WHERE nis = '$nis'");

    if ($hapus) {
        header("Location: siswa.php?msg=deleted");
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data dari database!');
                window.location.href = 'siswa.php';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Permintaan tidak valid!');
            window.location.href = 'siswa.php';
          </script>";
    exit();
}

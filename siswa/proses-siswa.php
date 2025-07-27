<?php
session_start();

if (!isset($_SESSION['ssLogin']) || $_SESSION['ssJabatan'] !== 'admin') {
    die("Akses ditolak. Hanya admin yang dapat mengakses halaman ini.");
}

require_once '../config.php'; // pastikan fungsi uploading() ada di sini

// --------------- SIMPAN SISWA BARU ---------------- //
if (isset($_POST['simpan'])) {
    $nis     = htmlspecialchars(trim($_POST['nis']));
    $nama    = htmlspecialchars(trim($_POST['nama']));
    $kelas   = htmlspecialchars(trim($_POST['kelas']));
    $alamat  = htmlspecialchars(trim($_POST['alamat']));

    // Upload foto jika ada, jika tidak gunakan default
    $foto = ($_FILES['image']['error'] === 4) ? 'default.png' : uploading("add-siswa.php");

    $query = "INSERT INTO tbl_siswa (nis, nama, alamat, kelas, foto) 
              VALUES ('$nis', '$nama', '$alamat', '$kelas', '$foto')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data Siswa berhasil disimpan!');
                window.location.href = 'siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data!');
                window.location.href = 'add-siswa.php';
              </script>";
    }
    exit();
}

// --------------- UPDATE SISWA ---------------- //
elseif (isset($_POST['update'])) {
    $nis_lama = htmlspecialchars(trim($_POST['nis_lama']));
    $nis      = htmlspecialchars(trim($_POST['nis']));
    $nama     = htmlspecialchars(trim($_POST['nama']));
    $kelas    = htmlspecialchars(trim($_POST['kelas']));
    $alamat   = htmlspecialchars(trim($_POST['alamat']));
    $fotoLama = $_POST['fotolama'];

    // Proses foto baru
    if ($_FILES['image']['error'] === 4) {
        $fotoSiswa = $fotoLama; // Tidak ganti foto
    } else {
        $fotoSiswa = uploading("edit-siswa.php");

        // Hapus foto lama jika bukan default
        $oldPath = '../asset/image/' . $fotoLama;
        if ($fotoLama !== 'default.png' && file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    $query = "UPDATE tbl_siswa SET 
                nis = '$nis',
                nama = '$nama',
                kelas = '$kelas',
                alamat = '$alamat',
                foto = '$fotoSiswa'
              WHERE nis = '$nis_lama'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data siswa berhasil diperbarui!');
                window.location.href = 'siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data!');
                window.location.href = 'siswa.php';
              </script>";
    }
    exit();
}
?>

<?php
session_start();
require_once '../config.php';

if (isset($_POST['simpan'])) {
    $nip      = htmlspecialchars($_POST['nip']);
    $nama     = htmlspecialchars($_POST['nama']);
    $telepon  = htmlspecialchars($_POST['telpon']); // sesuai nama input di form
    $agama    = htmlspecialchars($_POST['agama']);
    $alamat   = htmlspecialchars($_POST['alamat']);

    // Proses upload gambar
    $gambar   = $_FILES['image']['name'];
    $tmp      = $_FILES['image']['tmp_name'];
    $ext      = pathinfo($gambar, PATHINFO_EXTENSION);
    $valid    = ['png', 'jpg', 'jpeg'];
    $newName  = uniqid() . '.' . strtolower($ext);

    // Jika file gambar diupload dan format valid
    if ($gambar && in_array(strtolower($ext), $valid)) {
        move_uploaded_file($tmp, "../asset/image/" . $newName);
    } else {
        $newName = 'default.png'; // jika tidak upload gambar atau tidak valid
    }

    // Simpan ke database, sesuaikan nama kolom: telepon dan foto
    $query = "INSERT INTO tbl_guru (nip, nama, telepon, agama, alamat, foto) 
              VALUES ('$nip', '$nama', '$telepon', '$agama', '$alamat', '$newName')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data guru berhasil disimpan');
                window.location.href = 'guru.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data guru');
                window.history.back();
              </script>";
    }
}
?>

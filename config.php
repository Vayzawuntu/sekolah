<?php
// Buat koneksi
$koneksi = mysqli_connect("localhost", "root", "", "db_sekolah");

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// URL induk
$main_url = "http://localhost/sekolah/";

// Fungsi upload gambar
function uploading($redirect)
{
    $namafile = $_FILES['image']['name'];
    $ukuran   = $_FILES['image']['size'];
    $error    = $_FILES['image']['error'];
    $tmpname  = $_FILES['image']['tmp_name'];

    // Cek ekstensi file
    $extValid = ['jpg', 'jpeg', 'png'];
    $extFile  = strtolower(pathinfo($namafile, PATHINFO_EXTENSION));

    if (!in_array($extFile, $extValid)) {
        echo "<script>
                alert('Format file tidak valid! Hanya jpg, jpeg, png.');
                document.location.href = '$redirect';
              </script>";
        exit;
    }

    // Cek ukuran file
    if ($ukuran > 1000000) {
        echo "<script>
                alert('Ukuran file terlalu besar! Maksimal 1 MB.');
                document.location.href = '$redirect';
              </script>";
        exit;
    }

    // Buat nama file unik
    $newName = uniqid() . '.' . $extFile;

    // Upload file
    move_uploaded_file($tmpname, '../asset/image/' . $newName);
    return $newName;
}
?>

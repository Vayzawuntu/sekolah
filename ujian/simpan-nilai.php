<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data utama
    $noUjian     = $_POST['noUjian'];
    $tanggal     = $_POST['tanggal'];
    $nis         = $_POST['nis'];

    // Data nilai dan mapel
    $mapel       = $_POST['mapel'];       // array
    $kelasMapel  = $_POST['kelas_mapel']; // array
    $nilai       = $_POST['nilai'];       // array

    // Validasi dasar
    if (empty($noUjian) || empty($tanggal) || empty($nis) || empty($mapel)) {
        die("Data tidak lengkap!");
    }

    // Hitung statistik nilai
    $total_nilai     = array_sum($nilai);
    $nilai_terendah  = min($nilai);
    $nilai_tertinggi = max($nilai);
    $nilai_rata2     = round($total_nilai / count($nilai));

    // Tentukan kelulusan
    $isLulus = true;
    foreach ($nilai as $n) {
        if ($n < 50) {
            $isLulus = false;
            break;
        }
    }
    if ($nilai_rata2 < 60) $isLulus = false;

    $hasil_ujian = $isLulus ? 'Lulus' : 'Tidak Lulus';

    // Simpan ke tbl_ujian
    $queryUjian = mysqli_query($koneksi, "INSERT INTO tbl_ujian (no_ujian, tgl_ujian, nis, total_nilai, nilai_terendah, nilai_tertinggi, nilai_rata2, hasil_ujian) VALUES (
        '$noUjian', '$tanggal', '$nis', '$total_nilai', '$nilai_terendah', '$nilai_tertinggi', '$nilai_rata2', '$hasil_ujian'
    )");

    if ($queryUjian) {
        // Simpan ke tbl_nilai_ujian
        for ($i = 0; $i < count($mapel); $i++) {
            $pelajaran = mysqli_real_escape_string($koneksi, $mapel[$i]);
            $nilaiUjian = (int) $nilai[$i];

            mysqli_query($koneksi, "INSERT INTO tbl_nilai_ujian (no_ujian, pelajaran, nilai_ujian) VALUES (
                '$noUjian', '$pelajaran', '$nilaiUjian'
            )");
        }

        // Redirect atau tampilkan pesan
        echo "<script>
                alert('Data nilai berhasil disimpan!');
                window.location.href = 'ujian.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data utama!');
                window.history.back();
              </script>";
    }

} else {
    echo "<script>
            alert('Metode tidak diizinkan!');
            window.history.back();
          </script>";
}

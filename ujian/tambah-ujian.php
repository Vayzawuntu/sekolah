<?php
require_once "../config.php";

// Ambil data siswa untuk dropdown
$siswa = mysqli_query($koneksi, "SELECT nis, nama_siswa FROM tbl_siswa");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tgl = $_POST['tgl_ujian'];
    $nis = $_POST['nis'];
    $nilai_terendah = $_POST['nilai_terendah'];
    $nilai_tertinggi = $_POST['nilai_tertinggi'];
    $total_nilai = $_POST['total_nilai'];

    // Hitung rata-rata (misalnya total dibagi 4 mata pelajaran)
    $rata2 = $total_nilai / 4;

    // Tentukan hasil lulus/gagal
    $hasil = $rata2 >= 65 ? "Lulus" : "Gagal";

    $simpan = mysqli_query($koneksi, "INSERT INTO tbl_ujian 
        (tgl_ujian, nis, total_nilai, nilai_terendah, nilai_tertinggi, nilai_rata2, hasil_ujian) 
        VALUES ('$tgl', '$nis', '$total_nilai', '$nilai_terendah', '$nilai_tertinggi', '$rata2', '$hasil')");

    if ($simpan) {
        header("Location: index.php?msg=sukses");
        exit;
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}
?>

<h2>Tambah Data Ujian</h2>
<form method="POST">
    <label>Tanggal Ujian</label><br>
    <input type="date" name="tgl_ujian" required><br><br>

    <label>Nama Siswa</label><br>
    <select name="nis" required>
        <option value="">-- Pilih Siswa --</option>
        <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
            <option value="<?= $s['nis'] ?>"><?= $s['nis'] . " - " . $s['nama_siswa'] ?></option>
        <?php } ?>
    </select><br><br>

    <label>Total Nilai</label><br>
    <input type="number" name="total_nilai" required><br><br>

    <label>Nilai Terendah</label><br>
    <input type="number" name="nilai_terendah" required><br><br>

    <label>Nilai Tertinggi</label><br>
    <input type="number" name="nilai_tertinggi" required><br><br>

    <button type="submit">Simpan</button>
</form>

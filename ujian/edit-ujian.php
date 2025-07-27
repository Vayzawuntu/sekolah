<?php
require_once "../config.php";
$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM tbl_ujian WHERE no_ujian = $id");
$row = mysqli_fetch_assoc($data);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tgl = $_POST['tgl_ujian'];
    $nilai_terendah = $_POST['nilai_terendah'];
    $nilai_tertinggi = $_POST['nilai_tertinggi'];
    $total_nilai = $_POST['total_nilai'];
    $rata2 = $total_nilai / 4;
    $hasil = $rata2 >= 65 ? "Lulus" : "Gagal";

    $update = mysqli_query($koneksi, "UPDATE tbl_ujian SET 
                tgl_ujian='$tgl',
                total_nilai='$total_nilai',
                nilai_terendah='$nilai_terendah',
                nilai_tertinggi='$nilai_tertinggi',
                nilai_rata2='$rata2',
                hasil_ujian='$hasil'
                WHERE no_ujian=$id");

    if ($update) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        echo "Update gagal: " . mysqli_error($koneksi);
    }
}
?>

<h2>Edit Ujian</h2>
<form method="POST">
    <label>Tanggal Ujian</label><br>
    <input type="date" name="tgl_ujian" value="<?= $row['tgl_ujian'] ?>" required><br><br>

    <label>Total Nilai</label><br>
    <input type="number" name="total_nilai" value="<?= $row['total_nilai'] ?>" required><br><br>

    <label>Nilai Terendah</label><br>
    <input type="number" name="nilai_terendah" value="<?= $row['nilai_terendah'] ?>" required><br><br>

    <label>Nilai Tertinggi</label><br>
    <input type="number" name="nilai_tertinggi" value="<?= $row['nilai_tertinggi'] ?>" required><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>

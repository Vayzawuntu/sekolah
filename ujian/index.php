<?php 
require_once "../config.php";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Query ambil data ujian + data siswa
$ujian = mysqli_query($koneksi, "
    SELECT u.*, s.nis, s.nama 
    FROM tbl_ujian u
    JOIN tbl_siswa s ON u.id_siswa = s.id
    ORDER BY u.no_ujian DESC
");
?>

<h2>Data Ujian</h2>
<a href="tambah-ujian.php">+ Tambah Ujian</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Total</th>
        <th>Terendah</th>
        <th>Tertinggi</th>
        <th>Rata-rata</th>
        <th>Hasil</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($ujian)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['tgl_ujian'] ?></td>
        <td><?= $row['nis'] ?></td>
        <td><?= $row['nama'] ?></td> <!-- GANTI dari nama_siswa -->
        <td><?= $row['total_nilai'] ?></td>
        <td><?= $row['nilai_terendah'] ?></td>
        <td><?= $row['nilai_tertinggi'] ?></td>
        <td><?= $row['nilai_rata2'] ?></td>
        <td><?= $row['hasil_ujian'] ?></td>
        <td>
            <a href="edit-ujian.php?id=<?= $row['no_ujian'] ?>">Edit</a> | 
            <a href="hapus-ujian.php?id=<?= $row['no_ujian'] ?>" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

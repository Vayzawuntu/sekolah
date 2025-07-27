<?php
session_start();
if (!isset($_SESSION["ssLogin"])) {
    header("location:auth/login.php");
    exit;
}

// Ambil data dari sesi (gunakan fallback untuk keamanan)
$nama    = $_SESSION['ssNama'] ?? 'Pengguna';
$jabatan = strtolower($_SESSION['ssJabatan'] ?? 'tamu');

// Warna berdasarkan role
$warnaCard = [
    'admin'  => 'primary',
    'guru'   => 'success',
    'kepsek' => 'info',
    'siswa'  => 'warning'
];

$warna = $warnaCard[$jabatan] ?? 'secondary'; // fallback
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - <?= ucfirst($jabatan) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card border-<?= $warna ?> shadow mx-auto" style="max-width: 600px;">
        <div class="card-header bg-<?= $warna ?> text-white">
            <h4 class="mb-0">Selamat Datang, <?= $nama ?>!</h4>
        </div>
        <div class="card-body">
            <p class="fs-5">Anda login sebagai: <strong><?= ucfirst($jabatan) ?></strong></p>
            <hr>

            <?php if ($jabatan === 'admin'): ?>
                <h5>Menu Admin:</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="user/add-user.php">👤 Manajemen User</a></li>
                    <li class="list-group-item"><a href="guru/guru.php">📚 Data Guru</a></li>
                    <li class="list-group-item"><a href="siswa/siswa.php">👨‍🎓 Data Siswa</a></li>
                    <li class="list-group-item"><a href="pelajaran/pelajaran.php">📘 Data Pelajaran</a></li>
                    <li class="list-group-item"><a href="ujian/ujian.php">📝 Data Ujian</a></li>
                </ul>

            <?php elseif ($jabatan === 'kepsek'): ?>
                <h5>Menu Kepala Sekolah:</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="ujian/ujian.php">📊 Laporan Nilai Siswa</a></li>
                    <li class="list-group-item"><a href="guru/guru.php">👩‍🏫 Lihat Daftar Guru</a></li>
                    <li class="list-group-item"><a href="siswa/siswa.php">👨‍🎓 Lihat Daftar Siswa</a></li>
                    <li class="list-group-item"><a href="pelajaran/pelajaran.php">📘 Lihat Pelajaran Siswa</a></li>
                </ul>

            <?php elseif ($jabatan === 'guru'): ?>
                <h5>Menu Guru:</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="ujian/ujian.php">📝 Input Nilai Ujian</a></li>
                    <li class="list-group-item"><a href="siswa/siswa.php">👨‍🎓 Lihat Siswa</a></li>
                </ul>

            <?php elseif ($jabatan === 'siswa'): ?>
                <h5>Menu Siswa:</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="ujian/ujian.php">📊 Lihat Nilai Saya</a></li>
                    <li class="list-group-item"><a href="pelajaran/pelajaran.php">📘 Mata Pelajaran</a></li>
                </ul>

            <?php else: ?>
                <div class="alert alert-danger">
                    ⚠️ Role tidak dikenali. Silakan hubungi Administrator.
                </div>
            <?php endif; ?>

            <hr>
            <a href="auth/logout.php" class="btn btn-outline-danger w-100">🚪 Logout</a>
        </div>
    </div>
</div>

</body>
</html>

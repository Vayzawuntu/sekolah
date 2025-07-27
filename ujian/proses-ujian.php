<?php
session_start();
if (!isset($_SESSION['slogin'])) {
    header("location:../auth/login.php");
}
require_once "../config.php";

if (isset($_POST['simpan'])) {
    $noUjian = htmlspecialchars($_POST['noUjian']);
    $tgl = htmlspecialchars($_POST['tgl']);
    $nis = htmlspecialchars($_POST['nis']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $sum = htmlspecialchars($_POST['sum']);
    $min = htmlspecialchars($_POST['min']);
    $max = htmlspecialchars($_POST['max']);
    $avg = htmlspecialchars($_POST['avg']);
    
    if ($min < 50 or $avg < 60) {
            $hasilUjian = "GAGAL";
        } else {
            $hasilUjian = "LULUS";
        }

        $mapel = htmlspecialchars($_POST['mapel']);
        $jurusan = htmlspecialchars($_POST['kelas']);
        $nilai = htmlspecialchars($_POST['nilai']);

        mysqli_query($koneksi, "INSERT INTO tbl_ujian VALUES ('$noUjian', '$tgl', '$nis', '$kelas', '$sum', '$min', '$max', '$hasilUjian')");

        foreach ($mapel as $key => $mpl) {
            mysqli_query($koneksi, "INSERT INTO tbl_nilai_ujian VALUES (null, '$noUjian', '$mpl', '$kelas[$key]', '$nilai[$key]')");
        }

        header("location:nilai-ujian.php?msg=$hasilUjian&nis=$nis");
        return;

    }
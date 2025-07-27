<?

session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit();
}

require_once '../../config.php';

if (isset($_POST['simpan'])) {
    $pelajaran = htmlspecialchars($_POST['pelajaran']);
    $jurusan = $_POST['jurusan'];
    $guru = $_POST['guru'];

   $cekPelajaran = mysqli_query($koneksi, "SELECT * FROM tbl_pelajaran WHERE pelajaran = '$pelajaran'");
    if (mysqli_num_rows($cekPelajaran) > 0) {
        header("location:pelajaran.php?msg=cancel");
        return;
    }

    mysqli_query($koneksi, "INSERT INTO tbl_pelajaran VALUES (null, '$pelajaran', '$jurusan', '$guru')");

    header("location:pelajaran.php?msg=added");
    return;
}
<?php
session_start();
require_once "../config.php";

if (isset($_POST['login'])) {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim(htmlspecialchars($_POST['password']));
    $role     = strtolower(trim(htmlspecialchars($_POST['role']))); // lowercase dan aman

    // Cek user di database
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");

    if ($query && mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

        // Cek password (jika plain text)
        if ($password === $user['password']) {

            // Cek kesesuaian role dengan jabatan di DB
            if ($role === strtolower($user['jabatan'])) {

                // ✅ Simpan ke session
                $_SESSION['ssLogin']   = true;
                $_SESSION['ssUser']    = $username;
                $_SESSION['ssNama']    = $user['nama'];
                $_SESSION['ssJabatan'] = strtolower($user['jabatan']);
                $_SESSION['ssRole']    = strtolower($user['jabatan']); // Penting untuk dashboard & sidebar

                header("Location: ../index.php");
                exit;

            } else {
                echo "<script>
                    alert('Role tidak sesuai dengan akun.');
                    window.location.href = 'login.php';
                </script>";
            }

        } else {
            echo "<script>
                alert('Password salah.');
                window.location.href = 'login.php';
            </script>";
        }

    } else {
        echo "<script>
            alert('Username tidak ditemukan.');
            window.location.href = 'login.php';
        </script>";
    }

} else {
    header("Location: login.php");
    exit;
}

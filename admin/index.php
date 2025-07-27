<?php
session_start();
if (!isset($_SESSION["ssLogin"])) {
    header("Location: auth/login.php");
    exit;
}

if (strtolower($_SESSION["ssJabatan"]) !== "admin") {
    header("Location: auth/login.php");
    exit;
}
?>

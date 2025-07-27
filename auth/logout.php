<?php

session_start();
if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}
session_unset();
$_SESSION = [];




header("location: login.php");
exit;

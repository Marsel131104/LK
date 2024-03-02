<?php
session_start();

if (isset($_SESSION['users']) and (!in_array(session_id(), $_SESSION['users']))) {
    header("Location: index.php");
    die();
}

require "../db/db_connect.php";
$session_id = session_id();
mysqli_query($lnk, "UPDATE users SET session_id = '' WHERE session_id = '$session_id'");

$_SESSION['users'] = array_diff($_SESSION['users'], array($session_id));
header("Location: ../index.php");


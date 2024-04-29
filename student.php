<?php
ob_start(); // Start output buffering
session_start();


include "./templates/header.php";
require_once("conf/conf.php");
include "./templates/navbar.php";

?>

<?php include "./templates/footer.php"; ?>

<?php
ob_end_flush(); // Flush the output buffer
?>
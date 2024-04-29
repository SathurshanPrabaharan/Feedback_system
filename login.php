<?php
require_once "utils/constants.php";
ob_start(); // Start output buffering
session_start();


include "./templates/header.php";
require_once("conf/conf.php");

?>

<!--log in-->


<?php include "./templates/footer.php"; ?>

<?php
ob_end_flush(); // Flush the output buffer
?>
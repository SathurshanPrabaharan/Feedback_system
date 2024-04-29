<?php
    session_start();	

    // Unset all of the session variables	
    $_SESSION = array();	

    // Destroy the session	
    session_destroy();	

    $_SESSION['loggedin']=false;

    // Redirect to the login page 	
    header("Location: login.php");
    exit();
?>
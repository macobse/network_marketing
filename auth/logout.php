<?php
    session_start();
    // remove all session variables
    session_unset($_SESSION['user_session']); 

    // destroy the session 
    session_destroy(); 
    header("Location: ../index.php");
?>
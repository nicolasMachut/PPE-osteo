<?php
if(isset($_POST['deco'])){
    session_destroy();
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    header("location: ../index.php");
}
?>
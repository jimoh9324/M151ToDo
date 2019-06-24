<?php
        include('dbconnector.inc.php');

        //Session wird gestartet
        session_start();
        session_regenerate_id(true);
    
        $error = $message = '';
    
        //Session überprüfen
        if(isset($_SESSION['loggedin']))
        {
         $message .= "Hallo " . $_SESSION['username'] . ", du bist angemeldet.";
        }
    
        else
        {
            $error .= "Sie sind nicht angemeldet, bitte melden Sie sich auf der <a href='SW05login.php'>Login-Seite</a> an.";
            header('Location: login.php');
        }
?>



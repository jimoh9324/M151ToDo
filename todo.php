<?php
    // TODO: Verbindung zur Datenbank einbinden
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
        $error .= "Sie sin nicht angemeldet, bitte melden Sie sich auf der <a href='SW05login.php'>Login-Seite</a> an.";
    }

?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDos</title>
</head>
<body>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <div class='container'>
    <h1>ToDo Übersicht</h1>

    <?php
        if(!empty($error))
        {
            echo $error;
            echo '</br>';
        }

        else
        {
            echo $message;
            echo '</br>';
        }
    ?>
    </div>



            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
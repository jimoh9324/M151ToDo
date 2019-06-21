 <?php
    //To Dos for this file:
        //Durch VALIDIERTE Felder sollen die Spalten der DB befüllt werden
        //File soll nur zugänglich sein wenn man eingeloggt ist
        //  

    include('dbconnector.inc.php');

    //Session wird gestartet
    session_start();
    session_regenerate_id(true);

    $error = $message = '';

    //Session überprüfen
    if(!isset($_SESSION['loggedin']))
    {
        $error .= "Sie sind nicht angemeldet, bitte melden Sie sich auf der <a href='SW05login.php'>Login-Seite</a> an.";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo erstellen</title>
</head>
<body>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <div class='container'>
    <h1>ToDo erstellen</h1>

    <?php
        if(!empty($error))
        {
            echo $error;
            echo '</br>';
        }
    ?>
        
        <a class="btn btn-primary" href="todo.php" role="button">Abbrechen</a> 

    </div>




            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>




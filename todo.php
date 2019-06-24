<?php

//ToDo for this file:
    //
    //Loggout und Create To Do Button sollen nicht sichtbar sein, wenn man nicht eineloggt ist (es soll nur der Link auf die Login Seite sichtbar sein)
    //Aus der DB sollen alle ToDos für diesen Benutzer herausgelesen und angezeigt werden       


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
        $error .= "Sie sind nicht angemeldet, bitte melden Sie sich auf der <a href='SW05login.php'>Login-Seite</a> an.";
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

        <!-- Tabelle für die ToDos -->
        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Task</th>
                <th scope="col">Zu erledigen bis</th>
                <th scope="col">Wichtigkeit</th>
                <th scope="col">Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Offen</td>
                </tr>


                <tr>
                <?php
                    //Alle Todos für den jeweiligen Benutzer holen
                    $query = "SELECT * FROM todo";
                    $todos = $mysqli->query($query);

                    while($row = $todos->fetch_assoc())
                    {
                        echo "<tr><td>".$row["todoid"]."</td><td>".$row['task']."</td><td>".$row['target']."</td><td>".$row['priority']."</td><td>".$row['status']."</td></tr>";
                    }
                ?>
                </tr>
            </tbody>
        </table>

        <a class="btn btn-primary" href="createtodo.php" role="button">To Do erstellen</a> 
        <a class="btn btn-primary" href="loggout.php" role="button">Loggout</a>

    </div>




            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

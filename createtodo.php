 <?php

    include('dbconnector.inc.php');

    //Session wird gestartet
    session_start();
    session_regenerate_id(true);

    //Initialisierung der Variablen
    $error = $message = '';
    $task = $target = $priority = $status = '';
    $userid = $_SESSION['userid'];

    //Session überprüfen
    if (!isset($_SESSION['loggedin'])) {
        //Error Message wird nicht angezeigt, da weiterleitung auf login.php direkt erfolgt. So kann ein unautorisierter Benutzer die Seite gar nicht erst sehen.
        $error .= "Sie sind nicht angemeldet, bitte melden Sie sich auf der <a href='SW05login.php'>Login-Seite</a> an.";
        header('Location: login.php');
    }

    //überprüft ob Daten per Post gesendet worden sind
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //Serverseitige Validierung Task
        //task vorhanden, mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (isset($_POST['task']) && !empty(trim($_POST['task'])) && strlen(trim($_POST['task'])) <= 100) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $task = htmlspecialchars(trim($_POST['task']));
        } else {
            //Fehlermeldung wird in Variabel geschrieben
            $error .= "Die eingegebenen Informationen im Feld Task entsprechen nicht dem geforderten Format.<br />";
        }


        //Serverseitige Validierung Target
        //target vorhanden, mindestens 1 Zeichen lang
        if (isset($_POST['target']) && !empty(trim($_POST['target']))) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $target = htmlspecialchars(trim($_POST['target']));
        } else {
            //Fehlermeldung wird in Variabel geschrieben
            $error .= "Die eingegebenen Informationen im Feld Zu erledigen bis entsprechen nicht dem geforderten Format.<br />";
        }


        //Serverseitige Validierung Priotity
        //Priotity vorhanden, genau 1 Zeichen lang
        if (isset($_POST['priority']) && !empty(trim($_POST['priority'])) && (preg_match('/^\d{1}$/', $_POST['priority']))) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $priority = htmlspecialchars(trim($_POST['priority']));
        } else {
            //Fehlermeldung wird in Variabel geschrieben
            $error .= "Die eingegebenen Informationen im Feld Wichtigkeit entsprechen nicht dem geforderten Format.<br />";
        }


        //Serverseitige Validierung Status
        //Priotity vorhanden, genau 1 Zeichen lang
        if (isset($_POST['status']) && !empty(trim($_POST['status']))) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $status = htmlspecialchars(trim($_POST['status']));
        } else {
            //Fehlermeldung wird in Variabel geschrieben
            $error .= "Die eingegebenen Informationen im Feld Status entsprechen nicht dem geforderten Format.<br />";
        }




        if (empty($error)) {
            //INPUT Query erstellen, welches task, target, priority, status in die Datenbank schreibt
            $query = 'INSERT INTO todo (task, userid, target, priority, status) VALUES (?, ?, ?, ?, ?)';
            //Query vorbereiten mit prepare();
            $stmt = $mysqli->prepare($query);
            if ($stmt === false) {
                $error .= 'prepare failed ' . $mysqli->error . '<br />';
            }

            //Parameter an Query binden mit bind_param();
            if (!$stmt->bind_param('sisis', $task, $userid, $target, $priority, $status)) {
                $error .= 'bind failed ' . $mysqli->error . '<br />';
            }

            //Query ausführen mit execute();
            if (!$stmt->execute()) {
                $error .= 'execute failed ' . $mysqli->error . '<br />';
            }

            //Keine Fehler
            if (empty($error)) {
                $message .= "Die Daten wurden erfolgreich in die Datenbank geschrieben.<br />";
            }

            //Verbindung schliessen
            $mysqli->close();

            //Weiterleitung auf todo.php.
            header('Location: todo.php');
        }
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
            if (!empty($error)) {
                echo $error;
                echo '</br>';
            }
            ?>

         <form action="" method="post">
             <!-- Task -->
             <div class="form-group">
                 <label for="task">Task *</label>
                 <input type="text" name="task" class="form-control" id="firstname" value="<?php echo $task ?>" placeholder="Beschreiben Sie ihren Task" required="true">
             </div>


             <!-- Target -->
             <div class="form-group">
                 <label for="target">Zu erledigen bis *</label>
                 <input type="date" name="target" class="form-control" id="target" value="<?php echo $target ?>" required="true">
             </div>


             <!-- Priority -->
             <div class="form-group">
                 <label for="priority">Wichtigkeit (1 = sehr wichtig, 5 = nicht so wichtig) *</label>
                 <select name="priority" class="form-control" id="priority" value="<?php echo $priority ?>" required="true">
                     <option>1</option>
                     <option>2</option>
                     <option>3</option>
                     <option>4</option>
                     <option>5</option>
                 </select>
             </div>


             <!-- Status -->
             <div class="form-group">
                 <label for="status">Status *</label>
                 <select name="status" class="form-control" id="status" value="<?php echo $status ?>" required="true">
                     <option>Aktiv</option>
                     <option>Erledigt</option>
                 </select>
             </div>
             <button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
             <button type="reset" name="button" value="reset" class="btn btn-warning">Leeren</button>
             <a class="btn btn-warning" href="todo.php" role="button">Abbrechen</a>

         </form>
     </div>




     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <!-- Include all compiled plugins (below), or include individual files as needed -->
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 </body>

 </html>
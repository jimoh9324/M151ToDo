<?php

/*
19.07.2019 / JMER

Mit diesem Script werden die Foreign Keys für die Unit bei den Assets geupdated. Das Ziel ist die Units rechtig zu benennen

Benötigt:
- Tabelle mit neuen Units muss manuell erstellt werden
- Eine Translation Tabelle wird benötigt (welche alte ID passt zu welchen neuen ID)
- Am Ende muss die Verbindung wie Foreign Key zur neuen Unit Tabelle wieder hergestellt werden
*/

//DB Angaben für die Mysqli Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mobiliar_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 


//Alle Daten aller Assets aus der DB auslesen
$sql = "SELECT * FROM tbl_asset order by id_asset asc";
$result = $conn->query($sql);

//Schleife über jedes Asset
while($row = $result->fetch_assoc()) 
{
    //Wenn etwas zurückgeliefert wird
    if (!empty($row))
    {
        //Überprüft ob der Eintrag bereits geupdated wurde
        if ($row['updated'] <> 1)
        {

            //Alte ID als Variabel setzen
            $oldid = $row['fk_id_unit'];
            $assetid = $row['id_asset'];

            //Der Eintrag aus der tbl_translation, welcher der alten ID entspricht wird ausgelsen
            $sql_select_newid = "SELECT Idneu FROM tbl_translation WHERE IDalt = '$oldid' LIMIT 1";
            $result_newid = $conn->query($sql_select_newid);

            //Überprüfung ob das Resultat nicht leer ist
            if(!is_null($result_newid))
            {
                $row_newid = $result_newid->fetch_assoc();

                //Neue ID als Variabel setzen
                $newid = $row_newid ['Idneu'];
                //Alte und neue ID werden ausgegeben
                echo "Asset ID: " . $assetid;
                echo "</br>";
                echo "Alte ID: " . $oldid. " Neue ID: " . $newid;
                echo "<br>";

                //ID wird aktualisiert, updated wird auf 1 gesetzt
                $sql_update = "UPDATE tbl_asset SET fk_id_unit ='$newid', updated = 1 WHERE id_asset ='$assetid'";

                //Überprüfung ob Update durchgeführt wurde
                if (mysqli_query($conn, $sql_update)) 
                {
                    //Ausgabe wichtiger Informationen
                    $sql_test = "SELECT * FROM tbl_asset WHERE id_asset = '$assetid'";
                    $result_test = $conn->query($sql_test);
                    $row_test = $result_test->fetch_assoc();
                    $updatedid = $row_test['fk_id_unit'];
                    echo "Update des Assets mit der ID " . $assetid . " erfolgreich abgeschlossen. Updated ID: " . $updatedid;
                    echo "</br>";
                    echo "</br>";
                    
                } 
                else 
                {
                    //Fehlermeldung falls Update nicht durchgeführt werden konnte
                    echo "Error updating record: " . mysqli_error($conn);
                    echo "error in ".$sql_update;
                }
            }
            else
            {
                //Fehlermeldung falls kein 
                echo "Old ID not found";
            }
        }
    }

    //Wenn das Resultat leer ist
    else
    {
        echo "Record empty";
    }

     
}
//Mysqli Connection wird geschlossen
mysqli_close($conn);
?>
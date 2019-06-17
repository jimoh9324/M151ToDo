<?php
    $host = 'localhost';
    $username = 'todouser';
    $password = 'To151DoHellerMeyer';
    $database = '151todolist';

    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
       }

?>
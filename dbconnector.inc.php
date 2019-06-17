<?php
    $host = 'localhost';
    $username = 'sw05user';
    $password = 'Password01';
    $database = 'sw05';

    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
       }

?>
<?php
    $host = 'localhost';
    $username = 'todouser';
    $password = '4TcKZm8ZDm$WuHcAX?9^x';
    $database = '151todolist';

    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
       }

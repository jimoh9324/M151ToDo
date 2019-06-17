<?php

session_start();
session_regenerate_id(true);

$_SESSION = array();
session_destroy();

header('location: SW05login.php');

?>
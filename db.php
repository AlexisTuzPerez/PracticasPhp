<?php

$db_host = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_database = "app";

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0) {
    die('No es posible conectarse a la BD a['. $db->connect_error . ']');
}
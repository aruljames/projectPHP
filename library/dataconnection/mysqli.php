<?php

$DBCONNECTION = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
if (mysqli_connect_error()) {
    die("Databse Connection failed: " . $DBCONNECTION->connect_error);
}

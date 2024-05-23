<?php

define('T_DB_SERVER', '127.0.0.1'); 
define('T_DB_USERNAME', 'root'); 
define('T_DB_PASSWORD', ''); 
define('T_DB_NAME', 'teacher'); 

/* Attempt to connect to MySQL/MariaDB database */
$link = mysqli_connect(T_DB_SERVER, T_DB_USERNAME, T_DB_PASSWORD, T_DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
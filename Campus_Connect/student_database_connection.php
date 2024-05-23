<?php

define('S_DB_SERVER', '127.0.0.1'); 
define('S_DB_USERNAME', 'root'); 
define('S_DB_PASSWORD', '');  
define('S_DB_NAME', 'student');

/* Attempt to connect to MySQL/MariaDB database */
$link = mysqli_connect(S_DB_SERVER, S_DB_USERNAME, S_DB_PASSWORD, S_DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
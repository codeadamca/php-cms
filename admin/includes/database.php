<?php

$connect = mysqli_connect( 
    "localhost", // Host
    "root", // Username
    "root", // Password
    "database" // Database name
);

mysqli_set_charset( $connect, 'UTF8' );

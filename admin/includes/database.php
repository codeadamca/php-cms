<?php

$connect = mysqli_connect( 
    "host", // Host
    "username", // Username
    "password", // Password
    "database" // Database
);

mysqli_set_charset( $connect, 'UTF8' );

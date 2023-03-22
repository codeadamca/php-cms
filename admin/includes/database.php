<?php

$connect = mysqli_connect( 
    "<DB_HOST>", // Host
    "<DB_USER>", // Username
    "<DB_PASSWORD>", // Password
    "<DB_DATABASE>" // Database
);

mysqli_set_charset( $connect, 'UTF8' );

<?php

$connect = mysqli_connect( 
    "sql209.epizy.com", // Host
    "epiz_33812902", // Username
    "TIpZqtmwZ4B1S", // Password
    "epiz_33812902_cms" // Database
);

// (Dev) MAMP Local connection 

// $connect = mysqli_connect( 
//     "localhost", // Host
//     "root", // Username
//     "root", // Password
//     "epiz_33812902_cms" // Database
// );

mysqli_set_charset( $connect, 'UTF8' );

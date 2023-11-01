<?php
    $host = "localhost";
    $user = "archxxarch";
    $pw = "jihyeon7117!";
    $db = "archxxarch";

    $connect = new mysqli($host, $user, $pw, $db);
    $connect -> set_charset("utd-8");

    // if(mysqli_connect_errno()){
    //     echo "DATABASE Connect False";
    // } else {
    //     echo "DATABASE Connect True";
    // }
?>
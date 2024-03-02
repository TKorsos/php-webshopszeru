<?php

namespace traits;

trait Utilities {
    function getViewFile( $file ) {
        include(__DIR__."/../views/".$file.".php");
    }

    /*
    function connectProcess()
    {
        $connection = mysqli_connect("localhost", "root", "12345", "pcshop");
        mysqli_set_charset($connection, "utf8mb4");

        return $connection;
    }
    */ 
}
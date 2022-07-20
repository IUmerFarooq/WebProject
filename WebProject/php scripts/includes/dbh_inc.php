<?php

// Establish a connection
    function get_con() {
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "teasspices";

        try {
            if($con = mysqli_connect($server, $user, $pass, $db))   return $con;
             else   throw new Exception ("unable to connect");
        } catch (Exception $e) {
            echo $e -> getMessage();
        }
    }

// Closing a connection
    function close_con($con) {
        $con -> close();
        echo "closed";
    }
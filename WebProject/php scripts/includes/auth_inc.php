<?php

    function register($con) {
        $name = mysqli_real_escape_string($con, $_POST['Name']);
        $DOB = mysqli_real_escape_string($con, $_POST['DOB']);
        $ph = mysqli_real_escape_string($con, $_POST['ph']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $pass = mysqli_real_escape_string($con, $_POST['pass']);
        $hash = md5($pass);

        $cmd = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $res = mysqli_query($con, $cmd);
        $user = mysqli_fetch_assoc($res);

        if($user) {
            if($user['email'] === $email) {
                return 5; //return error
            }
        } else {
            $data = "INSERT INTO `kanban`.`users` (`name`, `DOB`, `ph`, `email`, `pass`, `image_name`) VALUES ('$name', '$DOB', '$ph', '$email', '$hash', 'a1.png')";
    
            if($con -> query($data) == true)    return 1;
            else    return 2;
        }
        
    }

    function login($con) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $hash = md5($pass);

        $cmd = "select * from users where email = '$email' and pass = '$hash'";
        $result = mysqli_query($con, $cmd);
        //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count =  mysqli_num_rows($result);

        if($count == 1) {
            session_start();
            $_SESSION['email'] = $email;
           return 1; 
        } else {
            return 2;
        }
    }

    
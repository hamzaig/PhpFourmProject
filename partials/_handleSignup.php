<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include "_dbconnect.php";
        $signupEmail = $_POST["signupEmail"];
        $signupPassword = $_POST["signupPassword"];
        $signupCpassword = $_POST["signupCpassword"];

        $existQuery = "SELECT * FROM `users` WHERE email='$signupEmail'";

        $result = mysqli_query($conn,$existQuery);
        $numRows = mysqli_num_rows($result);
        if($numRows>0){
            $showError = "Email Already in Use";
            header("Location: /?signupSuccess=false&error=$showError");
                    exit();
        }
        else{
            if($signupPassword == $signupCpassword){
                $hash = password_hash($signupPassword,PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`email`, `password`, `timestamp`) VALUES ( '$signupEmail', '$hash', current_timestamp())";
                $result = mysqli_query($conn,$sql);
                if($result){
                    $showAlert = true;
                    header("Location: /?signupSuccess=true");
                    exit();
                }else{
                    $showError = "Sql Error.";
                    header("Location: /?signupSuccess=false&error=$showError");
                    exit();
                }

            }else{
                $showError = "Passwords does not match.";
            }
        }
        
    }
    header("Location: /?signupSuccess=false&error=$showError");
    exit();


?>
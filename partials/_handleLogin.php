<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include "_dbconnect.php";
        $loginEmail = $_POST["loginEmail"];
        $loginPassword = $_POST["loginPassword"];

        $sql = "SELECT * FROM users WHERE email='$loginEmail'";
        $result = mysqli_query($conn,$sql);
        $numRows = mysqli_num_rows($result);
        if($numRows == 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($loginPassword,$row["password"])){
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["useremail"] = $loginEmail;
                $_SESSION["id"] = $row["id"];
                echo "Loggedin ". $loginEmail;
                header("Location: /");
                exit();
            }else{
                echo "Unable To Login";
                header("Location: /");
                exit();
            }

        }
    }

?>        
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Welcome to IGDiscuss - Coding Forums</title>
</head>

<body>


    <!-- ****************************db connection file********************* -->
    <?php include 'partials/_dbconnect.php'; ?>
    <!-- ****************************End db connection file********************* -->

    <!-- ****************************Navbar********************* -->
    <?php include 'partials/_header.php'; ?>
    <!-- ****************************End Navbar********************* -->


    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $thread_id = $row["thread_id"];
            $thread_title = $row["thread_title"];
            $thread_description = $row["thread_description"];
            $thread_user_id = $row["thread_user_id"];
        }
            $sql3 = "SELECT email FROM users WHERE id = '$thread_user_id'";
            $result3 = mysqli_query($conn,$sql3);
            $row3 = mysqli_fetch_assoc($result3);

    ?>
    <!-- ****************************Jumbortron********************* -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $thread_title; ?></h1>
            <p class="lead"><?php echo $thread_description; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other. No Spam / Advertising / Self-promote
                in the forums. ...
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Do not PM users asking for help. ...
                Remain respectful of other members at all times.</p>
            <p class="lead">
            <p><b>Posted by : <?php echo $row3["email"]?></b></p>
            </p>
        </div>
    </div>
    <!-- ****************************End Jumbortron********************* -->
   
   
   <?php
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=="POST"){
            $comment = $_POST["comment"];
            $user_id1 = $_POST["emailid"];

            $comment = str_replace("<","&lt",$comment);
            $comment = str_replace(">","&gt",$comment);
            // $user_id1 = $_SESSION["id"];


            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `user_id`, `comment_time`) VALUES ('$comment', '$id', '$user_id1', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                // Your Question is added Please Wait for community Response...
                // Success! 
                echo '<div class="alert alert-primary" role="alert">
                Success! Thanks for Response...
              </div>';
                
            }
        }
    ?>
   
   <?php
    if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true )){
        echo '
        <div class="container">
            <h1>Start Discussion</h1>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                <div class="form-group my-2">
                    <label for="comment" class="my-2"><b>Type Your Comment</b></label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                    <input type="hidden" name="emailid" value="'.$_SESSION["id"].'">
                <button type="submit" class="btn btn-success my-2">Submit Comment</button>
            </form>
        </div>
        ';
    }else{
        echo '<div class="container">
        <h1 class="py-2">Start Discussion</h1>
        <hr>
        <h3 class=" lead " style="color: red;">Please Login To Start Discussion</h3>
        <hr>
    </div>';
    }
    ?>





    <!-- ****************************Medial Objects********************* -->
    <div class="container" style="min-height: 400px;">
        <h1 class="py-2">Discussion</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $content = $row["comment_content"];
            $comment_time = $row["comment_time"];
            $user_id = $row["user_id"];
            $sql2 = "SELECT email FROM users WHERE id = '$user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '
            <div class="media" class="my-3">
            <img class="mr-3" src="img/userdefault.png" width="50px" alt="">
            <div class="media-body">
            <p class="my-0 ml-3" style="font-weight: bold" >'.$row2["email"].' at '.$comment_time.'</p>
                '.$content .'
            </div><hr>
        </div>
            ';
        }
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Result Found</p>
              <p class="lead">You Are First Person to Comment...</p>
            </div>
          </div>';
        }
        ?>
    </div>
    <!-- ****************************End Medial Objects********************* -->

    <!-- ****************************Footer********************* -->
    <?php include 'partials/_footer.php'; ?>
    <!-- ****************************End Footer********************* -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
</body>

</html>
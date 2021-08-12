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
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id=$id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row["category_name"];
            $catdesc = $row["category_description"];
        }

       
    ?>



    <!-- ****************************Jumbortron********************* -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> Forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other. No Spam / Advertising / Self-promote
                in the forums. ...
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Do not PM users asking for help. ...
                Remain respectful of other members at all times.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>
    <!-- ****************************End Jumbortron********************* -->


    <!-- ****************************Form********************* -->

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=="POST"){
            $thread_tit = $_POST["problemTitle"];
            $thread_desc = $_POST["problemDescription"];
            $user_id1 = $_POST["emailid"];

            $thread_tit = str_replace("<","&lt",$thread_tit);
            $thread_tit = str_replace(">","&gt",$thread_tit);

            $thread_desc = str_replace("<","&lt",$thread_desc);
            $thread_desc = str_replace(">","&gt",$thread_desc);

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_category_id`, `thread_user_id`, `timestamp`) VALUES ('$thread_tit', '$thread_desc', '$id', '$user_id1', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                // Your Question is added Please Wait for community Response...
                // Success! 
                echo '<div class="alert alert-primary" role="alert">
                Success! Your Question is added Please Wait for community Response...
              </div>';
                
            }
        }


    ?>
    <?php
    if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true )){
        echo '
        <div class="container">
        <h1 class="py-2">Ask Question</h1>
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <div class="form-group">
                <label for="problemTitle">Problem Title</label>
                <input type="text" class="form-control" name="problemTitle" id="problemTitle"
                    aria-describedby="problemTitle">
            </div>
            <div class="form-group my-2">
                <label for="description">Elleborate Your Problem</label>
                <input type="hidden" name="emailid" value="'.$_SESSION["id"].'">
                <textarea class="form-control" id="problemDescription" name="problemDescription" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success my-2">Submit</button>
        </form>
    </div>
        ';
    }else{
        echo '<div class="container">
        <h1 class="py-2">Ask Question</h1>
        <hr>
        <h3 class=" lead " style="color: red;">Please Login To Ask A Question</h3>
        <hr>
    </div>';
    }
    ?>
    <!-- ****************************End Form********************* -->

    <!-- ****************************Medial Objects********************* -->
    <div class="container" style="min-height: 400px;">
        <h1 class="py-2">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_category_id=$id";
        $result = mysqli_query($conn,$sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $thread_id = $row["thread_id"];
            $thread_title = $row["thread_title"];
            $thread_description = $row["thread_description"];
            $timestamp = $row["timestamp"];
            $thread_user_id = $row["thread_user_id"];
            $sql2 = "SELECT email FROM users WHERE id = '$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            


            echo '
            <div class="media" class="my-3">
            <img class="mr-3" src="img/userdefault.png" width="50px" alt="">
            <div class="media-body">
            
                <h5 class="mt-0"><a class="text-dark " href="thread.php?threadid='.$thread_id .'">'.$thread_title .'</a></h5>
              <div>  '.$thread_description .' </div>
            </div><p class="my-4 ml-3 " style="font-weight: bold" >'.$row2["email"].' at '.$timestamp.'</p>
        </div><hr>
            ';
        }
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Result Found</p>
              <p class="lead">You Are First Person to Ask Qustion...</p>
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
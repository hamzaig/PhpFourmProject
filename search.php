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

    



    <div class="container" style="min-height: 80vh;">
        <div class="searchresult my-3">
            <h1>Search Result for <em>"<?php echo $_GET["search"]; ?></em>"</h1>
        </div>
        <div class="result">
        <?php
            $search_query = $_GET['search'];
            $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title,thread_description) against ('$search_query')";
            $result = mysqli_query($conn,$sql);
            $noresult = true;
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    $thread_id = $row["thread_id"];
                    $thread_title = $row["thread_title"];
                    $thread_description = $row["thread_description"];
                    echo '<h4><a href="/cwh/php/fourmProject/thread.php?threadid='.$thread_id.'" class="text-dark">'.$thread_title.'</a></h4>
                    <p>'.$thread_description.'</p>';
                }
                if($noresult){
                    echo '<h4>No Result Found</h4>';
                }
        ?>
        </div>
    </div>




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
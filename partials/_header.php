<?php

session_start();
include '_dbconnect.php'; 


echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/">IgDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
          
        $sql = "SELECT * FROM `categories`";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
          echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row["category_id"].'">'.$row["category_name"].'</a></li>';
        }
        echo '</ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" tabindex="-1" >Contact</a>
      </li>
    </ul>
    <form class="d-flex justify-content-md-center" action = "search.php" method = "GET">
      <input class="form-control me-2" name = "search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success " type="submit">Search</button>
    </form>';
  
if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true )){
    echo ' <p style="color: white;padding: 0;margin: 0 5px;" class="text-light"><b> Welcome </b>'.$_SESSION["useremail"].'</p>
  <a href="partials/_logout.php"  class="btn btn-outline-success" id="logoutBtn" >Logout</a>';
}else{
  echo '<button class="btn btn-outline-success" id="loginbtn" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
     <button class="btn btn-outline-success" id="signupbtn" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
}
    
     
 echo ' </div>
</div>
</nav>';

include "partials/_loginModal.php";
include "partials/_signupModal.php";
  if(isset($_GET['signupSuccess'])  && $_GET['signupSuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success : </strong> You Are Registered Please Login...
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
 }

?>
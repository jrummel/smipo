<?php

require('connect.php');

  if(empty($_SESSION)) // if the session not yet started 
    session_start();

  $_SESSION['status'] = 0;

  $errorMsg = '';

  $username = $_POST['userid'];
  $userpass = $_POST['password'];

  $username = htmlspecialchars($username);
  $userpass = htmlspecialchars($userpass);

  $username = mysql_real_escape_string($username);
  $userpass = mysql_real_escape_string($userpass);

  $result = mysql_query("select username, member_id, status from members where username = '$username' AND password ='$userpass'");

  #checking if the result is NULL
  if (!$result){
    echo 'Could not run query: ' . mysql_error();
    exit;
  }

  #checking each returned value from the query - with '$username'
  if (mysql_num_rows($result)){
    while($row = mysql_fetch_array($result)) { 
      for($i=0;$i<=count($row);$i++) {
        if($row[$i]==$row['$username']){
          $_SESSION['user'] = $row['username'];
          $_SESSION['user_id'] = $row['member_id'];
          $_SESSION['status'] = $row['status'];
          $_SESSION['logged_in'] = true;
          header("Location:index.php");
          break;
        }
      }
      break;
    }
  }
  else{
  #set error message
    $errorMsg .= '<span style="color:#ff0000">Invalid Password and/or Username</span>';
  }

  ?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login - SMIPO</title>

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/smipo.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

  <!-- Javascript for Validation -->
  <script src="js/validateRegister.js" type="text/javascript"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>

  <?php require_once("navigation.php"); ?>

  <center>
    <div class="container">
      <div class="row">
        <div class="box">
          <div class="col-lg-12">
            <hr>
            <h2 class="intro-text text-center">Enter Your User Credentials
              <strong></strong>
            </h2>
          </hr>
          <form method="post" action="loginhandle.php" >
            <h2 class="form-signin-heading">Login</h2>
            <label for="inputUser" class="sr-only">Username</label>
            <input type="text" name="userid" id="userid" class="form-control" placeholder="Username" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="password" class="form-control" placeholder="Password" required>
            <p id="error">
              <?php 
              echo "$errorMsg";
              ?>
            </p>
            <button type="submit">Login</button>
          </form>
        </div>
        <a href="register.php">Not a user?</a>
      </div>
    </div>
  </div>
</center>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <p>Copyright &copy; Radford SMIPO 2015</p>
      </div>
    </div>
  </div>
</footer>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>


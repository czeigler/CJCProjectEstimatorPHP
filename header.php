<?php
require_once("dbConnExec.php");
require_once('headerFunctions.php');
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CJC Project Estimator - CIS 665 Colorado State University</title>
    <link href="main.css" rel="stylesheet" type="text/css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>

<div class="container">
  <div class="header"><img src="images/cjc_estimator_logo.png" width="282" height="35" alt="CJC Estimator Logo">
  <?php if (!loggedIn()) { ?>
  <div class="login">
    <form name="login" method="post" action="login.php" value="clickable button">
      <label for="userName">User Name:</label>
      <input name="userName" type="text" id="User Name" size="12">
      <label for="password">Password:</label>
      <input name="password" type="password" id="Password" size="12">
      <input name="submit" type="submit" value="Login" id="Submit">
    </form>
    </div>
  </div>
<?php } else { ?>
  <div class="login">
    <form name="logout" method="post" action="logout.php" value="clickable button">
      <input name="submit" type="submit" value="Logout" id="Submit">
    </form>
    </div>
  </div>
<?php } ?>    
    
    <div class="containernav">
<?php if (!loggedIn()) { ?>
    <a href="index.php">Home</a> |
<?php } else { ?>
    <a href="home.php">Project Home</a> |
<?php } ?>    
    <a href="about.php">About</a> | 
    <a href="signup.php">Sign-up</a>
    </div>



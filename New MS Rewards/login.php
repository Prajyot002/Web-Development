<?php

$login = false;
$showCredenError = false;
$showPassError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/_dbconnect.php';
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM `users` WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  
  if ($num == 1) {
    while($row = mysqli_fetch_assoc($result)){

      if (password_verify($password, $row['password'])) {
        
        $login = true;
        session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      header('Refresh:1.5; url=home.php');
      }
      else {
        $showPassError = true;
      }
    }
  } else {
    $showCredenError = true;
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/newmsr/css/maincon.css">
  <link rel="stylesheet" href="/newmsr/css/mainback.css">
  <title>Rewards Tracker - Login</title>
</head>

<body>
  <!-- <div class='light x1'></div>
  <div class='light x2'></div>
  <div class='light x3'></div>
  <div class='light x4'></div>
  <div class='light x5'></div>
  <div class='light x6'></div>
  <div class='light x7'></div>
  <div class='light x8'></div>
  <div class='light x9'></div> -->

  <div class="bg-animation">
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <div id="stars4"></div>
  </div>

  <div class="container">

  <h2>MS Rewards Tracker</h2>

    <form action="/newmsr/login.php" method="post">
      <p>Login</p>

      <label for="username">Username</label>
      <input type="text" placeholder="Enter your Username" id="username" name="username" required maxlength="11">

      <label for="password">Password</label>
      <input type="password" placeholder="Enter your Password" id="password" name="password" required maxlength="23">

      <button>Log In</button>

      <!-- <div class="err"> -->

        <?php
        if ($login) {
          echo '<h5>Login Success</h5>';
        }

        if ($showPassError) {
          header('Refresh:1; url=login.php');
          echo '<h4>Wrong Password</h5>';
        }
        if ($showCredenError) {
          header('Refresh:1; url=login.php');
          echo '<h4>Invalid Credentials</h5>';
        }
        ?>

      <!-- </div> -->
    </form>
    <div class="submitbtn">
      <h4>New User?</h4>
      <a href="/newmsr/signin.php">
        <button>Sign In</button>
      </a>
    </div>



  </div>

</body>

</html>
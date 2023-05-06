<?php

$showalert = false;
$showPassError = false;
$showUnameError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/_dbconnect.php';
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  $existSql = "SELECT * FROM `users` WHERE username = '$username'";
  $result = mysqli_query($conn, $existSql);
  $numExistsRow = mysqli_num_rows($result);
  if ($numExistsRow > 0) {
    $showUnameError = true;
  } else {
    if (($password == $cpassword)) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp());";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $showalert = true;
      }
    } else {
      $showPassError = true;
    }
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
  <title>Document</title>
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

    <form action="/newmsr/signin.php" method="post">
      <p>Sign In</p>

      <label for="username">Username</label>
      <input type="text" placeholder="Enter your Username" id="username" name="username" maxlength="11" required>

      <label for="password">Password</label>
      <input type="password" placeholder="Enter your Password" id="password" name="password" maxlength="23" required>

      <label for="password">Confirm Password</label>
      <input type="password" placeholder="Enter your Password" id="cpassword" name="cpassword" maxlength="23" required>

      <button type="submit">Sign In</button>
      <div class="err">

        <?php

        if ($showalert) {

          header('Refresh:1.2; url=login.php');
          echo '<h5>Account Created!</h5>';
        }
        if ($showUnameError) {

          header('Refresh:1.5; url=signin.php');
          echo '<h4>Username Alreay Exist</h5>';
        }
        if ($showPassError) {

          header('Refresh:1.5; url=signin.php');
          echo '<h4>Passwords do not match</h5>';
        }

        ?>
      </div>

    </form>
    <div class="backlogin">
      <a href="/newmsr/login.php">
        <button>Back to Log In</button>
      </a>
    </div>
  </div>
  <!-- redirecting code
  header('Refresh:3; url=login.php');
  echo 'Please Log In First';
-->

</body>

</html>
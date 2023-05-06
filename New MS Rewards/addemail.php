<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header("location: login.php");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
$username = $_SESSION["username"];
echo $username . '<br>';

$showEmailExist = false;
$showEmailAdded = false;
$showErrorAddingEmail = false;
$table_name = $username;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $email = $_POST["email"];

    // Creating and running query to check if email already exist
    $query = "SELECT * FROM %s WHERE email = ?";
    $stmt = $conn->prepare(sprintf($query, $table_name));
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $showEmailExist = true;
        //if email exist show email exist
    } else {
        //adding email
        $query = "INSERT INTO %s (`email`) VALUES (?)";
        $stmt = $conn->prepare(sprintf($query, $table_name));
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $showEmailAdded = true;
            header('Refresh:1.5; url=addemail.php');
        } else {
            $showErrorAddingEmail = true;
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
    <title>Rewards Tracker - Add Email</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="bg-animation">
        <div id="stars"></div>
        <div id="stars2"></div>
        <div id="stars3"></div>
        <div id="stars4"></div>
    </div>

    <div class="container">

        <h2>MS Rewards Tracker</h2>
        <form action="/newmsr/addemail.php" method="post">
            <h3>Add New Email</h3>
            <label for="email">Email</label>
            <input type="email" placeholder="Enter your Email" id="email" name="email" required>
            <br>
            <?php
            if ($showEmailExist == TRUE) {
                echo "<div class='notification'><h5>Email Already Exist!</h5></div>";
                echo "<script type='text/javascript'>";
                echo "$(function() {";
                    echo "$('div.notification').fadeIn().delay(500).fadeOut('slow');";
                    echo "});";   
                    echo "</script>";
                    $showEmailExist =false;
            }
            if ($showEmailAdded == TRUE) {
                echo "<div class='notification'><h5>Email Added</h5></div>";
                echo "<script type='text/javascript'>";
                echo "$(function() {";
                    echo "$('div.notification').fadeIn().delay(500).fadeOut('slow');";
                    echo "});";   
                    echo "</script>";
                    $showEmailAdded =false;
            }
            if ($showErrorAddingEmail == TRUE) {
                echo "<div class='notification'><h5>Error Adding Email</h5></div>";
                echo "<script type='text/javascript'>";
                echo "$(function() {";
                    echo "$('div.notification').fadeIn().delay(500).fadeOut('slow');";
                    echo "});";   
                    echo "</script>";
                    $showErrorAddingEmail =false;
            }
            ?>
            <button type="submit">Add Email</button>
        </form>
        <div class="submitbtn">
            <a class="nav-link" href="/newmsr/home.php"><button>Home</button></a>
            <a class="nav-link" href="/newmsr/logout.php"><button>Logout</button></a>
        </div>
    </div>
</body>

</html>
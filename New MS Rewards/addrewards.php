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

$showRewardAdded = false;
$showRewardError = false;

$table_name = $username;
$rewards_table = $username.'_rewards';


include 'partials/_dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $email = $_POST['email'];


    // Creating and running query 
    $query = "INSERT INTO %s (email, reward, date) VALUES (?, 250, ?) ON DUPLICATE KEY UPDATE reward = reward + 250";
    $stmt = $conn->prepare(sprintf($query, $rewards_table));
    $stmt->bind_param("ss", $email, $date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $showRewardAdded = true;
        header('Refresh:1.5; url=addrewards.php');
    } else {
        $showRewardError = true;
        header('Refresh:1.5; url=addrewards.php');
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
    <title>Rewards Tracker - Home</title>
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

        <form action="addrewards.php" autocomplete="off" method="post">
            <label for="email">Select Email:</label>

            <select name="email">
                <?php
                // Get the user's emails from the database

                $query = "SELECT email FROM %s";
                $stmt = $conn->prepare(sprintf($query, $table_name));
                $stmt->execute();
                $result = $stmt->get_result();
                $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($emails as $email) {
                    echo '<option value="' . $email['email'] . '">' . $email['email'] . '</option>';
                }
                ?>


            </select>
            <br>
            <label for="date">Select Date:</label>
            <input type="date" name="date">
            <br>
            <input type="submit" name="submit" value="Add Data">

            <?php
            if ($showRewardAdded == TRUE) {
                echo "<div class='notification'><h6>Reward Added</h6></div>";
                echo "<script type='text/javascript'>";
                echo "$(function() {";
                    echo "$('div.notification').fadeIn().delay(500).fadeOut('slow');";
                    echo "});";   
                    echo "</script>";
                    $showRewardAdded =false;
            }
            if ($showRewardError == TRUE) {
                echo "<div class='notification'><h6>Error Adding Reward</h6></div>";
                echo "<script type='text/javascript'>";
                echo "$(function() {";
                    echo "$('div.notification').fadeIn().delay(500).fadeOut('slow');";
                    echo "});";   
                    echo "</script>";
                    $showRewardError =false;
            }
            
            ?>


        </form>


        <a class="nav-link" href="/newmsr/home.php"><button>Home</button></a>
        <a class="nav-link" href="/newmsr/logout.php"><button>Logout</button></a>

    </div>





</body>

</html>
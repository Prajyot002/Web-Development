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

?>

<?php
            include 'partials/_dbconnect.php';
            // Get username from session
            $username = $_SESSION["username"];

            // Step 2: Check if user has a table associated with their username
            $table_name = $username; // Example table name based on username
            $rewards_table = $username.'_rewards';

            $sql = "SHOW TABLES LIKE '$table_name'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                // User doesnt have a table - display options to add data

                $sql = "CREATE TABLE $table_name (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(23) NOT NULL)";
                mysqli_query($conn, $sql);
                
                $query = "CREATE TABLE $rewards_table ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, email VARCHAR(50) NOT NULL, date DATE NOT NULL, reward INT(10) NOT NULL )";
                // $query= "CREATE TABLE $rewards_table (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT  PRIMARY KEY , email VARCHAR(23) NOT NULL , date DATE NOT NULL , reward INT(10) NOT NULL";
                mysqli_query($conn, $query);
            }
            
            ?>


<?php
            // Step 3: Handle adding data to existing table
            if (isset($_POST['add_email'])) {
                header("location: addemail.php");
            }
            if (isset($_POST['add_rewards'])) {

                header("location: addrewards.php");
            }
            if (isset($_POST['view_data'])) {

                header("location: viewdata.php");
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
    <link rel="stylesheet" href="/newmsr/css/mainback.css">
    <link rel="stylesheet" href="/newmsr/css/maincon.css">
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


        <form method="post">
            <p>Welcome - <?php echo $_SESSION["username"] ?></p>
            

            <button name="add_email">Add Email</button>

            <button name="add_rewards">Add Rewards</button>
            <button name="view_data">View Data</button>
           
        </form>

        <div class="submitbtn">

            <a class="nav-link" href="/newmsr/logout.php"><button>Logout</button></a>
        </div>

    </div>



</body>

</html>
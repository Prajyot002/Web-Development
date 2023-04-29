<!DOCTYPE html>
<html>
<head>
	<title>Rewards Tracker - View Data</title>
	<link rel="stylesheet" href="style2.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="container">
	<h1>View Data</h1>
	<table id="csstable">
		<div class="tab">
		<?php
			// Connecting to database
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "rewards";
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$conn) {
			    die("Connection failed: " . mysqli_connect_error());
			}

			// Retrieving data from database
			$sql = "SELECT email, SUM(reward) AS reward_amount FROM rewards GROUP BY email";
			$result = mysqli_query($conn, $sql);

			$total_reward = 0; //initialize variable to keep track of total reward amount
			if (mysqli_num_rows($result) > 0) {
					echo "<tr><th style='width: 200px;'>Email ID</th><th>Reward Amount</th></tr>";
				// Outputting data
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "<tr><td>" . $row["email"] . "</td><td>" . $row["reward_amount"] . "</td></tr>";
			        $total_reward += $row["reward_amount"]; // add current reward amount to total
			    }
			    // Display total reward amount after all individual rewards are displayed
			    echo "<strong><h3>Total: " . $total_reward . "</h3></strong>";
			} else {
			    echo "Null";
			}

			// Closing database connection
			mysqli_close($conn);
		?>
		</div>
	</table>
	<br>
	<a href="index.php"><button class="btn">Home</button></a>
	</div>
</body>
</html>

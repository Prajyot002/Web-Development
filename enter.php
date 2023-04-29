<!DOCTYPE html>
<html>

<head>
	<title>Rewards Tracker - Enter Data</title>
	<link rel="stylesheet" href="style1.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ysabeau:wght@300&display=swap" rel="stylesheet">
</head>

<body>
	<div class="container">
		<div class="heading">
			<h1>Enter Data</h1>
		</div>
		<div class="main">
			<form method="POST" action="enter.php" autocomplete="off">
				<label class="date" for="date">Date:</label>
				<input type="date" id="date" name="date" required><br><br>

				<label class="email" for="email">Email ID:</label>
				<select id="email" name="email" required>
					<option selected class="selected" value="" hidden>Select Email</option>
					<option value="email1@example.com">email1@example.com</option>
					<option value="email2@example.com">email2@example.com</option>
					<option value="email3@example.com">email3@example.com</option>
					<option value="email4@example.com">email4@example.com</option>
					<option value="email5@example.com">email5@example.com</option>
					<option value="email6@example.com">email6@example.com</option>
					<option value="email7@example.com">email7@example.com</option>
					<option value="email8@example.com">email8@example.com</option>
					<option value="email9@example.com">email9@example.com</option>
					<option value="email10@example.com">email10@example.com</option>
				</select><br><br>

				<div class="click">
					<button class="btn1" type="submit" name="Submit">Submit</button>
					<button class="btn2" type="reset" name="Reset">Reset</button>
				</div>

			</form>
			<br>
			<div class="gohome">
				<a href="index.php"><button class="btn3">Home</button></a>
			</div>
			<br>



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

		// Inserting data into database
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$date = $_POST['date'];
			$email = $_POST['email'];
			$sql = "INSERT INTO rewards (email, reward, date) VALUES ('$email', 250, '$date') ON DUPLICATE KEY UPDATE reward = reward + 250";
			if (mysqli_query($conn, $sql)) {
				mysqli_close($conn);
				header("Location: success.php");
    			exit();
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				mysqli_close($conn);
			}
		}

		// Closing database connection
		
	?>
		</div>
		<script>
			// Make success message disappear after 3 seconds
			setTimeout(function () {
				var successMsg = document.getElementById("success");
				if (successMsg != null) {
					successMsg.remove();
				}
			}, 1500);

		</script>
</body>

</html>
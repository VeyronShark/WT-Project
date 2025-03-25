<?php
	session_start();
	require 'connect.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = $_POST['userid'];
		$pass = $_POST['password'];
		
		$query = "select * from users where username = '$username' and pass = '$pass';";
		$result = mysqli_query($dbc, $query);
		
		if (mysqli_num_rows($result) > 0){
			$_SESSION['user'] = $username;
			$_SESSION['theme'] = 'blueberry';
			header('Location: hrisita/todolist.php');
            exit();
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Log In</title>
		<link id ='theme' rel="stylesheet" href="themes/<?php 
			if (isset($_SESSION['theme'])){
				echo $_SESSION['theme'];
			}
			else {
				echo 'blueberry';
			}
			?>.css">
		<style>
			div {
				text-align: center;
				margin: auto;
				width: 50%;
				border: 2px solid black;
			}
			#welcome {
				margin-top: 10%;
			}
			form {
				text-align: center;
				margin: auto;
				width: 300px;
				border: 2px solid black;
			}
			input {
				margin-bottom: 10px;
			}
		</style>
		<script>
			function displayRandomQuote() {
				const quotes = [
					"Your potential is limitless—dare to chase it.",
					"Every great achievement starts with the courage to begin.",
					"The difference between success and failure is persistence.",
					"You don’t have to be great to start, but you have to start to be great.",
					"Doubt kills more dreams than failure ever will.",
					"Discipline is choosing what you want most over what you want now.",
					"Your future is shaped by the actions you take today.",
					"Turn your setbacks into comebacks.",
					"Success is built on the days you don’t feel like showing up—but do anyway.",
					"Believe in the person you are becoming."
				];
				const randomIndex = Math.floor(Math.random() * quotes.length);
				document.getElementById('quote').innerHTML = quotes[randomIndex];
			}
		</script>
	</head>
	<body class='session' onload='displayRandomQuote();'>
		<div id="welcome">
			<h1>Productivity Manager</h1>
			<h2>Welcome!</h2>
		</div><br>
		<form class='session' action="" method="POST">
			<label for="userid">Username: </label>
			<input class='session' type="text" name="userid" placeholder="Username" required><br>
			
			<label for="password">Password: </label>
			<input class='session' type="password" name="password" placeholder="Password" required><br>
			
			<button class='loginsession' type="submit">Log In</button>
			
			<?php
				if (isset($result) and mysqli_num_rows($result) == 0){
					echo "<p style='color: red;'>Invalid Credentials</p>";
				}
			?>
		</form><br>
		
		<div class="loginsession">
			<p>Don't have an account? <a href="signup.php">Sign Up</a></p>
		</div><br><br>
		
		<div id="quote">
		</div>
	</body>
</html>
<?php
	require 'connect.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$username = $_POST['userid'];
		$pass = $_POST['password'];
		
		$query = "insert into users values ('$username', '$pass');";
		$result = mysqli_query($dbc, $query);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
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
				margin: auto;
				border: 2px solid black;
				width: 25%;
				text-align: center;
			}
			table {
				margin: auto;
				border: 2px solid black;
				text-align: right;	
			}
			input {
				margin-bottom: 5px;
			}
		</style>
		
		<script type="text/javascript">
			function toggleButton() {
				const pass = document.getElementById('password').value;
				const confirmpass = document.getElementById('confirmpassword').value;
				const button = document.getElementById('submitBtn');
				
				if (pass == confirmpass){
					button.disabled = false;
				}
				else{
					button.disabled = true;
				}
			}
			
			function onSignUp(){
				alert('Account Created. Please head to login page');
			}
		</script>
	</head>
	
	<body class='session'>
		<div id="welcome">
			<h1>Productivity Manager</h1>
			<h2>Create an Account</h2>
		</div><br>
		
		<form class='session' action="" method="POST">
			<table class='session'>
				<tr>
					<td><label for="userid">Username: </label></td>
					<td><input class='session' type="text" name="userid" id='userid' placeholder="Username" oninput="toggleButton();" required></td>
				</tr>
				
				<tr>
					<td><label for="password">Password: </label></td>
					<td><input class='session' type="password" name="password" id='password' placeholder="Password" oninput="toggleButton();" required></td>
				</tr>
				
				<tr>
					<td><label for="confirmpassword">Confirm Password: </label></td>
					<td><input class='session' type="password" name="confirmpassword" id='confirmpassword' placeholder="Confirm Password" oninput="toggleButton();" required></td>
				</tr>
			</table>
			
			<button class='signupsession' type="submit" id="submitBtn" onclick="onSignUp();">Sign Up</button>
		</form><br>
		
		<div class='signupsession'>
			<p>Already have an account? <a href="index.php">Log In</a></p>
		</div>
	</body>
</html>
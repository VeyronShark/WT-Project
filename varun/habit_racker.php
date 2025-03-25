<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: ../index.php");
	}
	require '../connect.php';
	$user = $_SESSION['user'];
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['habitname'])){
		    $habit_name = $_POST['habitname'];
        }
		$days = "";
		$days .= isset($_POST['mondaybox']) ? '1' : '0';
		$days .= isset($_POST['tuesdaybox']) ? '1' : '0';
		$days .= isset($_POST['wednesdaybox']) ? '1' : '0';
		$days .= isset($_POST['thursdaybox']) ? '1' : '0';
		$days .= isset($_POST['fridaybox']) ? '1' : '0';
		$days .= isset($_POST['saturdaybox']) ? '1' : '0';
		$days .= isset($_POST['sundaybox']) ? '1' : '0';
		if ($days == "0000000") {
			$days = "1111111";
		}

		if (isset($_POST['habitname'])){
            $query = "select * from habits where habit_name = '$habit_name' and username = '$user';";
		    $result = mysqli_query($dbc, $query);
            if(mysqli_num_rows($result) == 0){
                $query = "insert into habits values ('$user', '$habit_name', '$days');";
                $result = mysqli_query($dbc, $query);
            }
        }
	}

    if (isset($_POST['delete']) && isset($_POST['habits'])) {
		foreach ($_POST['habits'] as $habit) {
			$habit = mysqli_real_escape_string($dbc, $habit);
			$query = "DELETE FROM habits WHERE username = '$user' AND habit_name = '$habit';";
			mysqli_query($dbc, $query);
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Habit Tracker</title>
		<link id ='theme' rel="stylesheet" href="../themes/<?php 
			if (isset($_SESSION['theme'])){
				echo $_SESSION['theme'];
			}
			else {
				echo 'blueberry';
			}
			?>.css">
		
		<style>
			body {
				margin: 0;
				padding: 0;
				font-family: Arial, sans-serif;
				text-align: center;
			}
			.header-section header {
				padding: 20px;
			}
			.header-section header h1 {
				margin: 0;
				text-align: center;
				font-size: 36px;
			}
			.header-section .menu {
				display: flex;
				justify-content: center;
				gap: 20px;
				padding: 10px 0;
			}
			.header-section .menu a {
				text-decoration: none;
				color: black;
				font-size: 18px;
				padding: 8px 12px;
			}
			.header-section .dropdown {
				position: relative;
			}
			.header-section .dropbtn {
				background: none;
				border: none;
				font-size: 18px;
				cursor: pointer;
				padding: 8px 12px;
			}
			.header-section .dropdown-content {
				display: none;
				position: absolute;
				min-width: 120px;
				z-index: 10;
			}
			.header-section .dropdown-content a {
				display: block;
				padding: 8px 10px;
				text-decoration: none;
			}
			.header-section .dropdown:hover .dropdown-content {
				display: block;
			}
			#habitdetails {
				margin: 1.5% auto;
				width: 45%;
			}
			#createhabit{
				padding: 1%;
				width: 18%;
				margin: auto;
			}
			#functionality {
				width: 45%;
				margin: auto;
				margin-top: 1%;
				text-align: center;
			}
			table{
				width: 90%;
				margin: auto;
				margin-top: 1%;
				margin-bottom: 1%;
				border: 2px solid black;
				border-collapse: collapse;
			}
			td, th {
				border: 2px solid black;
			}
			h3 {
				border: 2px solid black;
				text-align: center;
				margin-bottom: 3%;
				margin-top: 3%;
			}
		</style>
		
		<script type='text/javascript'>
			function changeTheme(num) {
				const themes = ['blueberry', 'sage', 'lavender', 'smalt'];
					
				if (num >= 0 && num < themes.length) {
					if(num == 0){
					document.getElementById('theme').href = "../themes/blueberry.css";
					}
					if(num == 1){
						document.getElementById('theme').href = "../themes/sage.css";
					}
					if(num == 2){
						document.getElementById('theme').href = "../themes/lavender.css";
					}
					if(num == 3){
						document.getElementById('theme').href = "../themes/smalt.css";
					}

					// Send the theme preference to the server via AJAX
					fetch('../save_theme.php', {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: `theme=${themes[num]}`
					})
					.then(response => response.text())
					.then(data => console.log('Theme saved:', data))
					.catch(error => console.error('Error:', error));
				}
			}
			function createNewHabit(){
				loadDailyHabits();
			}
			
			function loadDailyHabits(){
				document.getElementById('dailyhabits').innerHTML = "<?php
					$dayIndex = date('N');
					$query = "SELECT distinct habit_name FROM habits WHERE username = '$user' AND SUBSTRING(days, $dayIndex, 1) = '1'";
					$result = mysqli_query($dbc, $query);
					
					while ($row = mysqli_fetch_array($result)){
						$habit_display = $row['habit_name'];
						echo "<input type='checkbox' name='$habit_display' value='$habit_display'>$habit_display<br>";
					}
				?>";
			}
			
			function bodyLoaded(){
				loadDailyHabits();
			}
		</script>
	</head>
	
	<body onload="bodyLoaded();">
		<!-- Header Section -->
		<div class="header-section">
			<header>
				<h1>Productivity Planner</h1>
			</header>
			<div id='menu' class="menu">
				<a href="../hrisita/todolist.php">TO-DO list</a>
				<a href="#">Habit Tracker</a>
				<a href="../vrinda/day_planner.php">Day Planner</a>
				<a href="../pratyush/timer.php">Focus Mode</a>
				<a href="../about.php">About</a>
				<a href="../logout.php">Logout</a>
				<div class="dropdown" id='dropdown'>
					<button class="dropbtn">Theme</button>
					<div class="dropdown-content">
						<a href="#" onclick="changeTheme(0)">Blueberry</a>
						<a href="#" onclick="changeTheme(1)">Sage</a>
						<a href="#" onclick="changeTheme(2)">Lavender</a>
						<a href="#" onclick="changeTheme(3)">Smalt</a>
					</div>
				</div>
			</div>
		</div>
		
		<h1 id='functionality'>Habit Tracker</h1>
		
		<div id="habitdetails">
			<table>
				<tr>
					<th>Habits for Today</th>
					<th>All Habits</th>
				</tr>
				<tr>
					<td>
						<form action="" method="POST">
							<div id='dailyhabits'>
							</div>
						</form>
					</td>
					
					<td>
						<form action="" method="POST">
							<div id="allhabits">
								<?php
								$query = "SELECT DISTINCT habit_name FROM habits WHERE username = '$user';";
								$result = mysqli_query($dbc, $query);

								while ($row = mysqli_fetch_array($result)) {
									$habit = $row['habit_name'];
									echo "<input type='checkbox' name='habits[]' value='$habit'>$habit<br>";
								}
								?>
							</div>
							<button id='btn1' type="submit" name="delete">Delete Selected Habits</button>
						</form>
					</td>
				<tr>
			</table>
		</div>
		
		<div id="createhabit">
			<form action="" method="POST">
				<h3>Create New Habit</h3>
				<label for='habitname'>Habit: </label>
				<input type='text' name='habitname' id='habitname' placeholder='Habit Name'required><br>
							
				<input type="checkbox" name="mondaybox" value="Mon"><label for="mondaybox">Monday</label><br>
				<input type="checkbox" name="tuesdaybox" value="Tue"><label for="tuesdaybox">Tuesday</label><br>
				<input type="checkbox" name="wednesdaybox" value="Wed"><label for="wednesdaybox">Wednesday</label><br>
				<input type="checkbox" name="thursdaybox" value="Thu"><label for="thursdaybox">Thursday</label><br>
				<input type="checkbox" name="fridaybox" value="Fri"><label for="fridaybox">Friday</label><br>
				<input type="checkbox" name="saturdaybox" value="Sat"><label for="saturdaybox">Saturday</label><br>
				<input type="checkbox" name="sundaybox" value="Sun"><label for="sundaybox">Sunday</label><br>
				(select all/none for daily recurring habit)<br>
				
				<button id='btn2' type="submit" onclick='loadDailyHabits();'>Create Habit</label>
			</form>
		</div>
	</body>
</html>
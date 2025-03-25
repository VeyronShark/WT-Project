<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: index.php");
        exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>About</title>
		<link id ='theme' rel="stylesheet" href="themes/<?php 
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
			#about {
				width: 70%; 
				margin: auto;
				border-radius: 10px;
			}
			.aboutp{
				width: 95%;
				margin: auto;
				border-radius: 10px;
				text-align: left;
				padding: 1%;
			}
			span.head {
				font-weight: bold;
				text-decoration: underline;
			}
			span.tab {
				margin-right: 3%;
			}
		</style>
		
		<script>
			function changeTheme(num) {
				const themes = ['blueberry', 'sage', 'lavender', 'smalt'];
				
				if (num >= 0 && num < themes.length) {
					if(num == 0){
					document.getElementById('theme').href = "themes/blueberry.css";
					}
					if(num == 1){
						document.getElementById('theme').href = "themes/sage.css";
					}
					if(num == 2){
						document.getElementById('theme').href = "themes/lavender.css";
					}
					if(num == 3){
						document.getElementById('theme').href = "themes/smalt.css";
					}

					// Send the theme preference to the server via AJAX
					fetch('save_theme.php', {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: `theme=${themes[num]}`
					})
					.then(response => response.text())
					.then(data => console.log('Theme saved:', data))
					.catch(error => console.error('Error:', error));
				}
			}
		</script>
	</head>
	
	<body>
		<!-- Header Section -->
		<div class="header-section">
			<header>
				<h1>Productivity Planner</h1>
			</header>
			<div id='menu' class="menu">
				<a href="hrisita/todolist.php">TO-DO list</a>
				<a href="varun/habit_racker.php">Habit Tracker</a>
				<a href="vrinda/day_planner.php">Day Planner</a>
				<a href="pratyush/timer.php">Focus Mode</a>
				<a href="#">About</a>
				<a href="logout.php">Logout</a>
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
		<br><br>
		<div id="about">
			<br>
			<p class='aboutp'>
				<span class='head'>About Productivity Planner</span><br><br>
				Productivity Planner is a project made by a team of 4: Varun Satapathy, Vrinda Patnaik, Hrisita Mohapatra and Pratyush Kumar Raut
				as their assignment for their course Web Technology under the guidance of Prof. Chandan Misra
				<br><br>
				This web application aims to help users organise their daily life by arranging things to do in "tasks", display the events for the day,
				track habits they wish to develop and enter monk mode for a certain time. See below how to use each function of the website
				<br><br>
				<span class='head'>TO-DO list (Hrisita Mohapatra-UCSE23024)</span><br><br>
				The TO-DO list allows the user to create tasks that are to be completed within a short preiod of time. Create a new task by 
				typing the name of the task in the textbox and clicking add.
				<br>The user can view tasks in the formats, 'All': all tasks created, 'Pending': tasks yet to be marked complete, 'Completed': tasks
				marked complete. Every task can be marked as complete by checking the checkbox to its left, or deleted by clicking the 'X' on its 
				right.
				<br><br>
				<span class='head'>Habit Tracker (Varun Satapathy-UCSE23063)</span><br><br>
				The Habit Tracker allows the user to keep track of habits according to the day on which it is to be completed. To create a habit,
				enter the name of the habit and the select the day during which it is to be completed, and finally click 'Create habit'. On creation,
				the habit will appear in the 'All habits' window and if the habit is to be completed today, it will appear in the 'Habits for today'
				window.
				<br><br>
				<span class='head'>Day Planner (Vrinda Patnaik-UCSE23064)</span><br><br>
				The Day planner allows the user to keep track of events that are to happen at a particular date. To add a new task, select a date for
				which the task must appear at, enter the name of the task and click 'Add Task'. To view all tasks or a day, simply select the date and
				click 'View Tasks'.
				<br><br>
				<span class='head'>Focus Mode (Pratyush Kumar Raut-UCSE23041)</span><br><br>
				The Focus mode allows the user to set a timer during which the user may stay in focus. Select the required minutes, seconds and click
				'start' to start the timer and 'stop' to end the timer early.
				<br><br>
				<span class='head'>MySQL Commands</span><br><br>
				These are the MySQL commands used for making the database for this web application:<br><br>
				CREATE database productivity;<br><br>
				CREATE table users (<br>
				<span class='tab'></span>username VARCHAR(50),<br>
				<span class='tab'></span>pass VARCHAR(50)<br>
				);<br><br>
				CREATE table habits (<br>
				<span class='tab'></span>username VARCHAR(50),<br>
				<span class='tab'></span>habit_name VARCHAR(100),<br>
				<span class='tab'></span>days VARCHAR(7)<br>
				);<br><br>
				CREATE TABLE tasks (<br>
				<span class='tab'></span>id INT AUTO_INCREMENT PRIMARY KEY,<br>
				<span class='tab'></span>username VARCHAR(30) DEFAULT NULL,<br>
				<span class='tab'></span>task TEXT NOT NULL,<br>
				<span class='tab'></span>date DATE NOT NULL<br>
				);<br><br>
			</p>
			<br>
		</div>
	</body>
</html>
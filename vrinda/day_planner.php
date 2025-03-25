<?php 
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: ../index.php");
        exit();
	}
	include '../connect.php';
	$username = $_SESSION['user'];
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		// Fetch tasks based on selected date
		$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
		$query = "SELECT task FROM tasks WHERE username = '$username' AND date = '$date'";
		$result = mysqli_query($dbc, $query);

		// Output tasks inside the table body
		$tasks = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$tasks[] = $row['task'];
		}
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['task']) && isset($_POST['date']))	{
			$task = $_POST['task'];
			$date = $_POST['date'];
		}

		if (isset($task) && isset($date)) {
			$query = "INSERT INTO tasks (username, task, date) VALUES ('$username', '$task', '$date')";
			mysqli_query($dbc, $query);
		}
		
		if (isset($_POST['delete_task'])){
			$task_to_delete = $_POST['delete_task'];
			$query = "delete from tasks where username = '$username' and task = '$task_to_delete'";
			mysqli_query($dbc, $query);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Day Planner</title>
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
        .planner-section {
            text-align: center;
        }
        .planner-section h1 {
            border: 2px solid black;
            width: 83%;
            margin: auto;
            margin-top: 2%;
            border-radius: 10px;
        }
        .planner-section input {
            border: 2px solid;
            padding: 0.9%;
            margin: 0.7%;
        }
        .planner-section input.view {
            padding: 0.6%;
        }
        .planner-section button {
            padding: 0.9%;
            margin: 0.7%;
        }
        .planner-section button.view {
            padding: 0.8%;
        }
        .planner-section div {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid black;
            margin-bottom: 20px;
            text-align: left;
        }
        .planner-section table {
            border: 2px solid black;
            border-collapse: separate;
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 5px;
            margin-left: auto;
            margin-right: auto;
        }
        .planner-section td {
            padding: 1%;
        }
		button.delete {
			padding: 5px 15px;
			margin: 0;
		}
		.tasktd {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
    </style>
	<script>
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
	</script>
</head>
<body>
    <!-- Header Section -->
    <div class="header-section">
        <header>
            <h1>Productivity Planner</h1>
        </header>
        <div id='menu' class="menu">
            <a href="../hrisita/todolist.php">TO-DO list</a>
            <a href="../varun/habit_racker.php">Habit Tracker</a>
            <a href="#">Day Planner</a>
            <a href="../pratyush/timer.php">Focus Mode</a>
            <a href="../about.php">About</a>
            <a href="../logout.php">Logout</a>
            <div class="dropdown" id='dayplannerdropdown'>
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

    <!-- Planner Section -->
    <div class="planner-section" id='dayplannersection'>
        <h1 id='plannerh1'>Day Planner</h1>
		<br>
        
        <form action="" method="GET">
            <input type="date" class="view" name="date" id="selectedDate">
            <button type="submit" class="view">View Tasks</button>
        </form>

        <div id='plannerview' class="planner">
            <form action="" method="POST">
                <input type="date" name="date" id="selectedDate">
                <input type="text" name="task" id="taskInput" placeholder="Enter a task" required>
                <button type="submit">Add Task</button>
            </form>
        </div>

        <div id='taskcontainer' class="tasks-container">
            <h2>Tasks for Selected Date<?php echo (isset($_GET['date'])) ?": " . $_GET['date'] : "";?></h2>
            <table id='tasktable'>
                <tbody id="taskTableBody">
                    <?php
						if(isset($tasks)){
							foreach ($tasks as $task) {
								echo "<tr id='tasktr'><td class='tasktd'> $task<form action='' method='POST'><button class='delete' name='delete_task' value='$task'>Delete</button><form></td></tr>";
							}	
						} 
					?>
                </tbody>
            </table>
        </div>
	</div>
</body>
</html>
   
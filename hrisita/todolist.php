<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: ../index.php");
        exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do List</title>
    <link id ='theme' rel="stylesheet" href="../themes/<?php 
			if (isset($_SESSION['theme'])){
				echo $_SESSION['theme'];
			}
			else {
				echo 'blueberry';
			}
			?>.css">
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
		document.addEventListener("DOMContentLoaded", () => {
			const taskInput = document.getElementById("task");
			const addTaskButton = document.getElementById("addTask");
			const taskList = document.getElementById("taskList");
			const clearAllButton = document.getElementById("clearAll");
			const allTab = document.getElementById("all");
			const pendingTab = document.getElementById("pending");
			const completedTab = document.getElementById("completed");

			let tasks = [];
			let taskIdCounter = 0;

			function showTasks(filter = "all") {
				taskList.innerHTML = "";

				for (let task of tasks) {
					if (filter === "pending" && task.completed) continue;
					if (filter === "completed" && !task.completed) continue;

					const li = document.createElement("li");
					li.innerHTML = `
						<input type="checkbox" ${task.completed ? "checked" : ""} data-id="${task.id}">
						<span class="${task.completed ? "completed-task" : ""}">${task.text}</span>
						<button class="delete-btn" data-id="${task.id}">X</button>
					`;

					taskList.appendChild(li);
				}
			}

			function setActiveTab(activeTab) {
				[allTab, pendingTab, completedTab].forEach(tab => tab.classList.remove("active"));
				activeTab.classList.add("active");
			}

			addTaskButton.addEventListener("click", () => {
				if (!taskInput.value.trim()) return;

				tasks.push({ id: taskIdCounter++, text: taskInput.value.trim(), completed: false });
				taskInput.value = "";
				showTasks();
			});

			taskList.addEventListener("change", (e) => {
				if (e.target.type === "checkbox") {
					let task = tasks.find(t => t.id == e.target.dataset.id);
					task.completed = e.target.checked;
					showTasks();
				}
			});

			taskList.addEventListener("click", (e) => {
				if (e.target.classList.contains("delete-btn")) {
					tasks = tasks.filter(task => task.id != e.target.dataset.id);
					showTasks();
				}
			});

			clearAllButton.addEventListener("click", () => { tasks = []; showTasks(); });

			[allTab, pendingTab, completedTab].forEach(tab => {
				tab.addEventListener("click", () => {
					showTasks(tab.id);
					setActiveTab(tab);
				});
			});

			showTasks();
		});
	</script>
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
		.container {
			padding: 20px;
			border-radius: 8px;
			text-align: center;
			width: 800px;
			margin: 20px auto;
		}
		#heading {
			margin: 0 0 15px;
			display: inline-block;
			border-bottom: 3px solid black;
			padding-bottom: 5px;
		}
		.task-input {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 15px;
		}
		.task-input input {
			flex: 1;
			padding: 5px;
			margin: 0 10px;
			border: 1px solid #888;
			border-radius: 4px;
		}
		.task-input button {
			padding: 5px 10px;
			cursor: pointer;
			border-radius: 4px;
		}
		.filter-tabs {
			display: flex;
			justify-content: space-around;
			margin-bottom: 10px;
			font-weight: bold;
		}
		.filter-tabs .tab {
			cursor: pointer;
			padding: 5px;
		}
		.filter-tabs .active {
			text-decoration: underline;
		}
		ul {
			list-style: none;
			padding: 0;
			text-align: left;
		}

		li {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 5px;
			border-bottom: 1px solid #888;
		}
		.completed-task {
			text-decoration: line-through;
			color: gray;
		}
	</style>
</head>
<body>
    <!-- Header Section -->
    <div class="header-section">
        <header>
            <h1>Productivity Planner</h1>
        </header>
        <div id='menu' class="menu">
            <a href="#">TO-DO list</a>
            <a href="../varun/habit_racker.php">Habit Tracker</a>
            <a href="../vrinda/day_planner.php">Day Planner</a>
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

    <!-- To-Do List -->
    <div class="container">
        <h1 id="heading">TO-DO List</h1>
        <div class="task-input">
            <label for="task">Enter a task:</label>
            <input type="text" id="task" placeholder="Type your task...">
            <button id="addTask">Add</button>
        </div>
        <div class="filter-tabs">
            <span class="tab active" id="all">All</span>
            <span class="tab" id="pending">Pending</span>
            <span class="tab" id="completed">Completed</span>
            <button id="clearAll">Clear All</button>
        </div>
        <div class="task-tabs">
            <ul id="taskList"></ul>
        </div>
    </div>
</body>
</html>

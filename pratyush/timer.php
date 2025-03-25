<?php 
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: ../index.php");
        exit();
	}
	header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Productivity Planner with Timer</title>
	<link id ='theme' rel="stylesheet" href="../themes/<?php 
			if (isset($_SESSION['theme'])){
				echo $_SESSION['theme'];
			}
			else {
				echo 'blueberr';
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
        .timer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 70vh;
            font-family: sans-serif;
        }

        #timer {
            font-size: 4em;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .timer-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .timer-controls label {
            font-size: 1.2em;
            font-weight: bold;
        }

        .timer-controls input {
            padding: 8px;
            font-size: 1.2em;
            width: 80px;
            text-align: center;
            border: 2px solid #DFD7CC;
            border-radius: 5px;
        }

        .timer-buttons {
            display: flex;
            gap: 15px;
        }

        button {
            padding: 12px 20px;
            font-size: 1.2em;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background 0.3s ease;
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
            <a href="../vrinda/day_planner.php">Day Planner</a>
            <a href="#">Focus Mode</a>
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

    <div class="timer-container">
        <div id="timer">00:00</div>
        <div class="timer-controls">
            <label for="minutes">Minutes:</label>
            <input type="number" id="minutes" value="1" min="0">
            <label for="seconds">Seconds:</label>
            <input type="number" id="seconds" value="0" min="0" max="59">
        </div>
        <div class="timer-buttons">
            <button id="start">Start</button>
            <button id="stop" style="display: none;">Stop</button>
        </div>
    </div>

    <script>
        let timerInterval;
        let remainingTime;
        const timerDisplay = document.getElementById('timer');
        const minutesInput = document.getElementById('minutes');
        const secondsInput = document.getElementById('seconds');
        const startButton = document.getElementById('start');
        const stopButton = document.getElementById('stop');

        function updateTimerDisplay() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function startTimer() {
            const minutes = parseInt(minutesInput.value, 10);
            const seconds = parseInt(secondsInput.value, 10);
            remainingTime = minutes * 60 + seconds;
            if (isNaN(remainingTime) || remainingTime < 0) {
                alert("Please enter a valid time.");
                return;
            }
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                remainingTime--;
                if (remainingTime < 0) {
                    clearInterval(timerInterval);
                    timerDisplay.textContent = '00:00';
                    startButton.style.display = 'block';
                    stopButton.style.display = 'none';
                    return;
                }
                updateTimerDisplay();
            }, 1000);
            startButton.style.display = 'none';
            stopButton.style.display = 'block';
        }

        function stopTimer() {
            clearInterval(timerInterval);
            startButton.style.display = 'block';
            stopButton.style.display = 'none';
        }

        startButton.addEventListener('click', startTimer);
        stopButton.addEventListener('click', stopTimer);
    </script>

</body>
</html>

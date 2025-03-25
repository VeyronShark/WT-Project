About Productivity Planner
  Productivity Planner is a project made by a team of 4: Varun Satapathy, Vrinda Patnaik, Hrisita Mohapatra and Pratyush Kumar Raut as their assignment for their course Web Technology under the guidance of 
  Prof. Chandan Misra. This web application aims to help users organise their daily life by arranging things to do in "tasks", display the events for the day, track habits they wish to develop and enter monk 
  mode for a certain time. See below how to use each function of the website

TO-DO list (Hrisita Mohapatra-UCSE23024)
  The TO-DO list allows the user to create tasks that are to be completed within a short preiod of time. Create a new task by typing the name of the task in the textbox and clicking add. The user can view tasks 
  in the formats, 'All': all tasks created, 'Pending': tasks yet to be marked complete, 'Completed': tasks marked complete. Every task can be marked as complete by checking the checkbox to its left, or deleted 
  by clicking the 'X' on its right.

Habit Tracker (Varun Satapathy-UCSE23063)
  The Habit Tracker allows the user to keep track of habits according to the day on which it is to be completed. To create a habit, enter the name of the habit and the select the day during which it is to be 
  completed, and finally click 'Create habit'. On creation, the habit will appear in the 'All habits' window and if the habit is to be completed today, it will appear in the 'Habits for today' window.

Day Planner (Vrinda Patnaik-UCSE23064)
  The Day planner allows the user to keep track of events that are to happen at a particular date. To add a new task, select a date for which the task must appear at, enter the name of the task and click 
  'Add Task'. To view all tasks or a day, simply select the date and click 'View Tasks'.

Focus Mode (Pratyush Kumar Raut-UCSE23041)
  The Focus mode allows the user to set a timer during which the user may stay in focus. Select the required minutes, seconds and click 'start' to start the timer and 'stop' to end the timer early.

MySQL Commands
  These are the MySQL commands used for making the database for this web application:

  CREATE database productivity;
  
  CREATE table users (
    username VARCHAR(50),
    pass VARCHAR(50)
  );
  
  CREATE table habits (
    username VARCHAR(50),
    habit_name VARCHAR(100),
    days VARCHAR(7)
  );
  
  CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) DEFAULT NULL,
    task TEXT NOT NULL,
    date DATE NOT NULL
  );



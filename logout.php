<?php
	require 'connect.php';
	mysqli_close($dbc);
	session_unset();
	session_destroy();
	header('Location: index.php');
    exit();
?>
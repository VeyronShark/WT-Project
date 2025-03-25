<?php
	session_start();
	if (isset($_POST['theme'])) {
		$theme = $_POST['theme'];
		$_SESSION['theme'] = $_POST['theme'];
	}
?>

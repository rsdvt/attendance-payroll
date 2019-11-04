<?php
	$conn = new mysqli('localhost', 'root', '', 'sdk');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>
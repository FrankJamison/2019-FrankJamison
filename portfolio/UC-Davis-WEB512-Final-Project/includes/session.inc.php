<?php
// Start Session
session_start();

// Check to See if Session Variables are Set for Valid User Session
if (!isset($_SESSION['member_name']) && !isset($_SESSION['member_id'])) {

	// Redirect to Public Login Page
	header('Location: ../index.php');
}
?>
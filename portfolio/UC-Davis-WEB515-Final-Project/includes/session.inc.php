<?php
// Start Session
session_start();

// Check to See if Session Variables are Set for Valid User Session
if (!isset($_SESSION['memberUsername']) && !isset($_SESSION['memberID'])) {

	// Redirect to Public Login Page
	header('Location: ' . $ROOT . '/index.php');
}
?>
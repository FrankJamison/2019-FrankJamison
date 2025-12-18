<?php

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
$error_text = "";

// Includes
require_once('../includes/constants.inc.php');
require_once('../includes/variables.inc.php');
require_once('../includes/session.inc.php');

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
    or die('Error connecting to database server');

// Member Username
$memberUsername = $_SESSION['memberUsername'];
$memberID = $_SESSION['memberID'];
/*
$dbc = "mysql:host=$host;dbname=$dbname;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dbc, $web_user, $pwd, $opt);
*/

$characterID = isset($_GET['characterID']) ? (int) $_GET['characterID'] : 0;

// Select statements for drop down fields
$sql = "SELECT * FROM characters WHERE characterID = $characterID";

$result = mysqli_query($dbc, $sql);

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

$character = mysqli_fetch_assoc($result);

// Remove html encoded quotes from values
foreach ($character as &$text) {
    $text = html_entity_decode($text, ENT_QUOTES);
}

echo json_encode($character);

mysqli_close($dbc);
?>
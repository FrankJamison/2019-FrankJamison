<?php

ob_start();

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

// Member Username
$memberUsername = $_SESSION['memberUsername'];

// Switch to HTML to Display Output
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quest Keeper - Member Area</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Main CSS -->
    <link href="<?= $ROOT ?>/css/style.css" rel="stylesheet" type="text/css" media="all" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Main JS -->
    <script type="text/javascript" src="<?= $ROOT ?>/js/script.js"></script>

</head>

<body>
    <!-- Page Header -->
    <header id="header">
        <div class="home-header">

            <!-- Left Header Navigation -->
            <div class="header-left">
                <nav class="home-nav-text">
                    <p><a href="<?= $ROOT ?>/members/index.php" title="Return to Member Home">Home</a></p>
                </nav>
            </div>

            <!-- Right Header Login Form -->
            <div class="header-right">
                <button type="button" onclick="location.href='logout.php';">Log Out</button>
            </div>
            <div class="clearfix"></div>

            <!-- Main Navigation -->
            <div class="w3_navigation">
                <div class="container">
                    <nav class="navbar navbar-default">
                        <div class="left-navigation">
                            <nav class="cl-effect-5" id="cl-effect-5">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="<?= $ROOT ?>/members/addCharacter.php"><span
                                                data-hover="Add Character">Add Character</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="center-navigation">
                            <h1><a href="<?= $ROOT ?>/members/index.php"><span>Quest Keeper</span></a></h1>
                        </div>
                        <div class="right-navigation">
                            <nav class="cl-effect-5" id="cl-effect-5">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="<?= $ROOT ?>/members/editCharacter.php"><span
                                                data-hover="Edit Character">Edit Character</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- End Main Navigation -->
        </div>
    </header>

    <!-- Main Content -->
    <main id="content">
        <div class="title-info">
            <h4>Hello, <?= $memberUsername; ?></h4>
            <p>Welcome to the Quest Keeper Character Tracker Member Area</p>
        </div>
    </main>
    <!-- End Main Content -->

    <!-- Footer Content -->
    <footer id="footer">
        <p class="copyright"></p>
    </footer>
    <!-- End Footer Content -->

</body>

</html>

<!-- Close Database Connection -->
<?php
$pdo = null;
ob_end_flush();
?>
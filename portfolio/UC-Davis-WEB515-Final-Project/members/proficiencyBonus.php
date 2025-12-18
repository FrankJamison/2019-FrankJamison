<?php

// Includes
require_once("../includes/constants.inc.php");
require_once("../includes/functions.inc.php");
require_once("../includes/variables.inc.php");
require_once("../includes/session.inc.php");
require_once("../includes/proficiencyBonus.inc.php");


// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
$error_text = "";

// Set local variables from GET variables
$characterLevel = isset($_GET["characterLevel"]) ? (int) $_GET["characterLevel"] : 1;

// If character level is not set, set to 1
if ($characterLevel == 21) {
    $characterLevel = 1;
}

/* Calculate proficiency bonus function
-------------------------------------------------------------------*/
function calcProficiencyBonus($characterLevel)
{

    $bonus = getProficiencyBonus($characterLevel);

    // Display proficiency bonus
    echo "<input name=\"proficiencyBonus\" id=\"proficiencyBonus\" value=\"+$bonus\" />";
}

// Calculate proficiency bonus
calcProficiencyBonus($characterLevel);

?>
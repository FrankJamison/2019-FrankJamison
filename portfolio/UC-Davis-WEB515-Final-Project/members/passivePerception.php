<?php
require_once("../includes/constants.inc.php");
require_once("../includes/functions.inc.php");
require_once("../includes/variables.inc.php");
require_once("../includes/session.inc.php");
require_once("../includes/proficiencyBonus.inc.php");

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set("display_errors", "1");
$error_text = "";

// Set local variables from GET variables
$wisdomScore = isset($_GET["wisdomScore"]) ? (int) $_GET["wisdomScore"] : 10;
$isProficient = isset($_GET["isProficient"]) ? $_GET["isProficient"] : false;
$characterLevel = isset($_GET["characterLevel"]) ? $_GET["characterLevel"] : 1;

// Calculate skill bonus function
function calcPassivePerception($wisdomScore, $isProficient, $characterLevel)
{

    // Get wisdom modifier
    $wisdomModifier = getAbilityModifier($wisdomScore);

    // Get proficiency bonus
    $proficiencyBonus = getProficiencyBonus($characterLevel);

    // Calculate passive perception
    if ($isProficient == "true") {
        $passivePerception = $wisdomModifier + $proficiencyBonus + 10;
    } else {
        $passivePerception = $wisdomModifier + 10;
    }

    // Display skill bonus
    if ($passivePerception >= 0) { // If the passive perception is 0 or greater, add a '+' in front of it
        echo "<input name='passivePerception' id='passivePerception' value='+$passivePerception' type='text' />";
    } else {
        echo "<input name='passivePerception' id='passivePerception' value='$passivePerception' type='text' />";
    }
}

// Calculate skill bonus
calcPassivePerception($wisdomScore, $isProficient, $characterLevel);

?>
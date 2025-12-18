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
$abilityScore = isset($_GET["abilityScore"]) ? (int) $_GET["abilityScore"] : 10;
$saveBonusType = isset($_GET["saveBonusType"]) ? $_GET["saveBonusType"] : 0;
$isProficient = isset($_GET["isProficient"]) ? $_GET["isProficient"] : false;
$characterLevel = isset($_GET["characterLevel"]) ? $_GET["characterLevel"] : 1;

// Calculate save bonus function
function calcSaveBonus($abilityScore, $saveBonusType, $isProficient, $characterLevel)
{

    // Get ability modifier
    $abilityModifier = getAbilityModifier($abilityScore);

    // Set character level to 1 if no level is selected
    if ($characterLevel == 21) {
        $characterLevel = 1;
    }

    // Get proficiency bonus
    $proficiencyBonus = getProficiencyBonus($characterLevel);

    // Calculate save bonus
    if ($isProficient == "true") {
        $saveBonus = $abilityModifier + $proficiencyBonus;
    } else {
        $saveBonus = $abilityModifier;
    }

    // Display saving throw modifier
    if ($saveBonus >= 0) { // If the save bonus value is 0 or greater, add a '+' in front of it
        echo "<input name='$saveBonusType' id='$saveBonusType' value='+$saveBonus' type='text' />";
    } else {
        echo "<input name='$saveBonusType' id='$saveBonusType' value='$saveBonus' type='text' />";
    }
}

// Calculate save bonus
calcSaveBonus($abilityScore, $saveBonusType, $isProficient, $characterLevel);

?>
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
$skillBonusType = isset($_GET["skillBonusType"]) ? $_GET["skillBonusType"] : 0;
$isProficient = isset($_GET["isProficient"]) ? $_GET["isProficient"] : false;
$characterLevel = isset($_GET["characterLevel"]) ? $_GET["characterLevel"] : 1;

// Calculate skill bonus function
function calcSkillBonus($abilityScore, $skillBonusType, $isProficient, $characterLevel)
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
        $skillBonus = $abilityModifier + $proficiencyBonus;
    } else {
        $skillBonus = $abilityModifier;
    }

    // Display skill bonus
    if ($skillBonus >= 0) { // If the skill bonus is 0 or greater, add a '+' in front of it
        echo "<input name='$skillBonusType' id='$skillBonusType' value='+$skillBonus' type='text' />";
    } else {
        echo "<input name='$skillBonusType' id='$skillBonusType' value='$skillBonus' type='text' />";
    }
}

// Calculate skill bonus
calcSkillBonus($abilityScore, $skillBonusType, $isProficient, $characterLevel);

?>
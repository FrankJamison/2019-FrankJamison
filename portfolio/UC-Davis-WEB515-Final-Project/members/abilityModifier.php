<?php

// Includes
require_once("../includes/constants.inc.php");
require_once("../includes/variables.inc.php");
require_once("../includes/session.inc.php");

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
$error_text = "";

// Set local variables from GET variables
$abilityScore = isset($_GET['abilityScore']) ? (int) $_GET['abilityScore'] : 0;
$abilityModifier = isset($_GET['abilityModifier']) ? $_GET['abilityModifier'] : 0;


// Calculate ability mod function
function calcAbilityMod($score, $abilityModifier)
{

    //Set modifier to the (ability score / 2) - 5
    $modifier = floor($score / 2) - 5;

    // Display ability modifier
    if ($modifier >= 0) { // If the modifier is 0 or positive, add a '+' in front of it
        echo "<input name='$abilityModifier' id='$abilityModifier' value='+$modifier' />";
    } else {
        echo "<input name='$abilityModifier' id='$abilityModifier' value='$modifier' />";
    }
}

// Calculate ability modifier
calcAbilityMod($abilityScore, $abilityModifier);

?>
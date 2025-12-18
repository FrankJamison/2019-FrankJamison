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
$memberID = $_SESSION['memberID'];

$dbc = "mysql:host=$host;dbname=$dbname;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dbc, $web_user, $pwd, $opt);

// Select statements for drop down fields
$sqlCharacterCount = "SELECT count(*) FROM characters WHERE userID = $memberID";
$sqlCharacter = "SELECT characterID, characterName FROM characters WHERE userID = $memberID";
$sqlClass = "SELECT classID, className FROM classes";
$sqlLevel = "SELECT levelID, levelNumber FROM levels";
$sqlRace = "SELECT raceID, raceName FROM races";
$sqlBackground = "SELECT backgroundID, backgroundName FROM backgrounds";
$sqlUsername = "SELECT userID, userUsername FROM users WHERE userID=$memberID";
$sqlAlignment = "SELECT alignmentID, alignmentName FROM alignments";

//Prepare the select statements.
$stmtCharacterCount = $pdo->prepare($sqlCharacterCount);
$stmtCharacter = $pdo->prepare($sqlCharacter);
$stmtClass = $pdo->prepare($sqlClass);
$stmtLevel = $pdo->prepare($sqlLevel);
$stmtRace = $pdo->prepare($sqlRace);
$stmtBackground = $pdo->prepare($sqlBackground);
$stmtUsername = $pdo->prepare($sqlUsername);
$stmtAlignment = $pdo->prepare($sqlAlignment);

//Execute the statements.
$stmtCharacterCount->execute();
$stmtCharacter->execute();
$stmtClass->execute();
$stmtLevel->execute();
$stmtRace->execute();
$stmtBackground->execute();
$stmtUsername->execute();
$stmtAlignment->execute();

//Retrieve the class rows using fetchAll.
$numCharacters = $stmtCharacterCount->fetchColumn();
$characters = $stmtCharacter->fetchAll();
$classes = $stmtClass->fetchAll();
$levels = $stmtLevel->fetchAll();
$races = $stmtRace->fetchAll();
$backgrounds = $stmtBackground->fetchAll();
$usernames = $stmtUsername->fetchAll();
$alignments = $stmtAlignment->fetchAll();

$nextCharacter = $numCharacters + 1;

$characterID = "";

// Switch to HTML to Display Output
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quest Keeper - A D&amp;D Character Database</title>
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
            <!-- End Left Header Navigation -->

            <!-- Right Header Login Form -->
            <div class="header-right">
                <button type="button" onclick="location.href='logout.php';">Log Out</button>
            </div>
            <div class="clearfix"></div>
            <!-- End Right Header Login Form -->

            <!-- Main Navigation -->
            <div class="w3_navigation">
                <div class="container">
                    <nav class="navbar navbar-default">

                        <!-- Left Navigation Area -->
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
                        <!-- End Left Navigation Area -->

                        <!-- Title Area -->
                        <div class="center-navigation">
                            <h1><a href="<?= $ROOT ?>/members/index.php"><span>Quest Keeper</span></a></h1>
                        </div>
                        <!-- End Title Area -->

                        <!-- Right Navigation Area -->
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
                        <!-- End Right Navigation Area -->
                    </nav>
                </div>
            </div>
            <!-- End Main Navigation -->
        </div>
    </header>
    <!-- End Page Header -->

    <!-- Main Content -->
    <main id="content">

        <!-- Character Sheet Form -->
        <form action="<?= $ROOT ?>/members/updateCharacter.php" method="post" class="characterSheet">

            <!-- Character Sheet Header -->
            <div class="characterSheetHeader">

                <!-- Character Name Section -->
                <section class="characterName">

                    <!-- Character Name Placeholder -->
                    <input name="characterNameText" id="characterNameText" type="text" hidden>
                    <!-- End Character Name Placeholder -->

                    <!-- Character Name Selector -->
                    <label for="characterName">Character Name</label>
                    <select name="characterName" id="characterName" tabindex="1" data-toggle="tooltip"
                        title="Select your character">
                        <?php foreach ($characters as $character): ?>
                            <option value="<?= $character['characterID']; ?>"><?= $character['characterName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- End Character Name Selector -->
                </section>
                <!-- End Character Name Section -->

                <!-- Miscellaneous Character Information -->
                <!-- Miscellaneous Character Data -->
                <section class="misc">
                    <ul>
                        <li>
                            <label for="characterClass">Class &amp; Level</label>
                            <div class="CharacterClassLevel">

                                <!-- Character Class-->
                                <select name="characterClass" id="characterClass" tabindex="2" data-toggle="tooltip"
                                    title="Select your character's class">
                                    <option value="13" selected="true">Class</option>
                                    <?php foreach ($classes as $class): ?>
                                        <?php if ($class['classID'] == 13) {
                                            continue;
                                        } ?>
                                        <option value="<?= $class['classID']; ?>"><?= $class['className']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- End Character Class -->

                                <!-- Character Level -->
                                <select name="characterLevel" id="characterLevel" tabindex="3" data-toggle="tooltip"
                                    title="Select your character's level">
                                    <option value="21" selected="true">Lvl</option>
                                    <?php foreach ($levels as $level): ?>
                                        <?php if ($level['levelID'] == 21) {
                                            continue;
                                        } ?>
                                        <option value="<?= $level['levelID']; ?>"><?= $level['levelNumber']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- End Character Level -->
                            </div>
                        </li>
                        <li>
                            <!-- Character Background -->
                            <label for="characterBackground">Background</label>
                            <select name="characterBackground" id="characterBackground" tabindex="4"
                                data-toggle="tooltip" title="Select your character's background">
                                <option value="19" selected="true">Background</option>
                                <?php foreach ($backgrounds as $background): ?>
                                    <?php if ($background['backgroundID'] == 19) {
                                        continue;
                                    } ?>
                                    <option value="<?= $background['backgroundID']; ?>">
                                        <?= $background['backgroundName']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- End Character Background -->
                        </li>
                        <li>
                            <!-- Member User ID -->
                            <label for="playerName">Player Name</label>
                            <select name="playerName" id="playerName">
                                <?php foreach ($usernames as $username): ?>
                                    <option value="<?= $username['userID']; ?>" selected="true" readonly="readonly">
                                        <?= $username['userUsername']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- End Member User ID -->
                        </li>
                        <li>
                            <!-- Character Race -->
                            <label for="characterRace">Race</label>
                            <select name="characterRace" id="characterRace" tabindex="5" data-toggle="tooltip"
                                title="Select your character's race">
                                <option value="20" selected="true">Race</option>
                                <?php foreach ($races as $race): ?>
                                    <?php if ($race['raceID'] == 20) {
                                        continue;
                                    } ?>
                                    <option value="<?= $race['raceID']; ?>"><?= $race['raceName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- End Character Race -->
                        </li>
                        <li>
                            <!-- Character Alignment -->
                            <label for="characterAlignment">Alignment</label>
                            <select name="characterAlignment" id="characterAlignment" tabindex="6" data-toggle="tooltip"
                                title="Select your character's alignment">
                                <option value="10" selected="true">Alignment</option>
                                <?php foreach ($alignments as $alignment): ?>
                                    <?php if ($alignment['alignmentID'] == 10) {
                                        continue;
                                    } ?>
                                    <option value="<?= $alignment['alignmentID']; ?>"><?= $alignment['alignmentName']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- End Character Alignment -->
                        </li>
                        <li>
                            <!-- Experience Points -->
                            <label for="experiencePoints">Experience Points</label>
                            <input name="experiencePoints" id="experiencePoints" type="text" placeholder="XP"
                                tabindex="7" data-toggle="tooltip" title="Enter your character's XP">
                            <!-- End Experience Points -->
                        </li>
                    </ul>
                </section>
                <!-- End Miscellaneous Character Data -->
            </div>
            <!-- End Character Sheet Header -->

            <!-- Character Sheet Body -->
            <div class="characterSheetMain">

                <!-- Character Sheet Column 1 -->
                <section>

                    <!-- Character Attributes -->
                    <section class="attributes">

                        <!-- Ability Scores -->
                        <div class="abilityScores">
                            <ul>
                                <li>
                                    <!-- Strength Score -->
                                    <div class="abilityScore">
                                        <label for="strengthScore">Strength</label>
                                        <input name="strengthScore" id="strengthScore" placeholder="10" tabindex="8"
                                            data-toggle="tooltip" title="Enter your character's STR" />
                                    </div>
                                    <!-- End Strength Score -->

                                    <!-- Strength Modifier -->
                                    <div class="abilityModifier" id="strengthMod">
                                        <input name="strengthModifier" id="strengthModifier" value="+0" readonly />
                                    </div>
                                    <!-- End Strength Modifier -->
                                </li>
                                <li>
                                    <!-- Dexterity Score -->
                                    <div class="abilityScore">
                                        <label for="dexterityScore">Dexterity</label>
                                        <input name="dexterityScore" id="dexterityScore" placeholder="10" tabindex="9"
                                            data-toggle="tooltip" title="Enter your character's DEX" />
                                    </div>
                                    <!-- End Dexterity Score -->

                                    <!-- Dexterity Modifier -->
                                    <div class="abilityModifier" id="dexterityMod">
                                        <input name="dexterityModifier" id="dexterityModifier" value="+0" readonly />
                                    </div>
                                    <!-- End Dexterity Modifier -->
                                </li>
                                <li>
                                    <!-- Constitution Score -->
                                    <div class="abilityScore">
                                        <label for="constitutionScore">Constitution</label>
                                        <input name="constitutionScore" id="constitutionScore" placeholder="10"
                                            tabindex="10" data-toggle="tooltip" title="Enter your character's CON" />
                                    </div>
                                    <!-- End Constitution Score -->

                                    <!-- Constitution Modifier -->
                                    <div class="abilityModifier" id="constitutionMod">
                                        <input name="constitutionModifier" id="constitutionModifier" value="+0"
                                            readonly />
                                    </div>
                                    <!-- End Constitution Modifier -->
                                </li>
                                <li>
                                    <!-- Intelligence Score -->
                                    <div class="abilityScore">
                                        <label for="intelligenceScore">Intelligence</label>
                                        <input name="intelligenceScore" id="intelligenceScore" placeholder="10"
                                            tabindex="11" data-toggle="tooltip" title="Enter your character's INT" />
                                    </div>
                                    <!-- End Intelligence Score -->

                                    <!-- Intelligence Modifier -->
                                    <div class="abilityModifier" id="intelligenceMod">
                                        <input name="intelligenceModifier" id="intelligenceModifier" value="+0"
                                            readonly />
                                    </div>
                                    <!-- End Intelligence Modifier -->
                                </li>
                                <li>
                                    <!-- Wisdom Score -->
                                    <div class="abilityScore">
                                        <label for="wisdomScore">Wisdom</label>
                                        <input name="wisdomScore" id="wisdomScore" placeholder="10" tabindex="12"
                                            data-toggle="tooltip" title="Enter your character's WIS" />
                                    </div>
                                    <!-- End Wisdom Score -->

                                    <!-- Wisdom Modifier -->
                                    <div class="abilityModifier" id="wisdomMod">
                                        <input name="wisdomModifier" id="wisdomModifier" value="+0" readonly />
                                    </div>
                                    <!-- End Wisdom Modifier -->
                                </li>
                                <li>
                                    <!-- Charisma Score -->
                                    <div class="abilityScore">
                                        <label for="charismaScore">Charisma</label>
                                        <input name="charismaScore" id="charismaScore" placeholder="10" tabindex="13"
                                            data-toggle="tooltip" title="Enter your character's CHA" />
                                    </div>
                                    <!-- End Charisma Score -->

                                    <!-- Charisma Modifier -->
                                    <div class="abilityModifier" id="charismaMod">
                                        <input name="charismaModifier" id="charismaModifier" value="+0" readonly />
                                    </div>
                                    <!-- End Charisma Modifier -->
                                </li>
                            </ul>
                        </div>
                        <!-- End Ability Scores -->

                        <!-- Attribute Applications -->
                        <div class="attributeApplications">

                            <!-- Inspiration -->
                            <div class="inspiration box">
                                <div class="label-container">
                                    <label for="inspiration">Inspiration</label>
                                </div>
                                <input name="inspiration" id="inspiration" tabindex="14" data-toggle="tooltip"
                                    title="Enter your character's Inspiration bonus" />
                            </div>
                            <!-- End Inspiration -->

                            <!-- Proficiency Bonus -->
                            <div class="proficiencybonus box">
                                <div class="label-container">
                                    <label for="proficiencybonus">Proficiency Bonus</label>
                                </div>
                                <div id="proficiencyBonusDiv">
                                    <input name="proficiencyBonus" id="proficiencyBonus" value="+2" readonly />
                                </div>
                            </div>
                            <!-- End Proficiency Bonus -->

                            <!-- Ability Saves -->
                            <div class="saves list-section box">
                                <ul>
                                    <li>
                                        <!-- Strength Save -->
                                        <label for="strengthSave">Strength</label>
                                        <div id="strengthSaveDiv" class="saveMod">
                                            <input name="strengthSave" id="strengthSave" class="saveModifier" value="+0"
                                                type="text" readonly />
                                        </div>
                                        <!-- End Strength Save -->

                                        <!-- Strength Proficiency -->
                                        <input name="strengthSaveProficiency" value="0" type="hidden" />
                                        <input name="strengthSaveProficiency" id="strengthSaveProficiency" tabindex="15"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in STR" />
                                        <!-- End Strength Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Dexterity Save -->
                                        <label for="dexteritySave">Dexterity</label>
                                        <div id="dexteritySaveDiv" class="saveMod">
                                            <input name="dexteritySave" id="dexteritySave" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Dexterity Save -->


                                        <!-- Dexterity Proficiency -->
                                        <input name="dexteritySaveProficiency" value="0" type="hidden" />
                                        <input name="dexteritySaveProficiency" id="dexteritySaveProficiency"
                                            tabindex="16" type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in DEX" />
                                        <!-- End Dexterity Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Constitution Save -->
                                        <label for="constitutionSave">Constitution</label>
                                        <div id="constitutionSaveDiv" class="saveMod">
                                            <input name="constitutionSave" id="constitutionSave" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Constitution Save -->

                                        <!-- Constitution Proficiency -->
                                        <input name="constitutionSaveProficiency" value="0" type="hidden" />
                                        <input name="constitutionSaveProficiency" id="constitutionSaveProficiency"
                                            tabindex="17" type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in CON" />
                                        <!-- End Constitution Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Intelligence Save -->
                                        <label for="intelligenceSave">Intelligence</label>
                                        <div id="intelligenceSaveDiv" class="saveMod">
                                            <input name="intelligenceSave" id="intelligenceSave" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Intelligence Save -->

                                        <!-- Intelligence Proficiency -->
                                        <input name="intelligenceSaveProficiency" value="0" type="hidden" />
                                        <input name="intelligenceSaveProficiency" id="intelligenceSaveProficiency"
                                            tabindex="18" type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in INT" />
                                        <!-- End Intelligence Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Wisdom Sava -->
                                        <label for="wisdomSave">Wisdom</label>
                                        <div id="wisdomSaveDiv" class="saveMod">
                                            <input name="wisdomSave" id="wisdomSave" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Wisdom Save -->

                                        <!-- Wisdom Proficiency -->
                                        <input name="wisdomSaveProficiency" value="0" type="hidden" />
                                        <input name="wisdomSaveProficiency" id="wisdomSaveProficiency" tabindex="19"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in WIS" />
                                        <!-- End Wisdom Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Charisma Save -->
                                        <label for="charismaSave">Charisma</label>
                                        <div id="charismaSaveDiv" class="saveMod">
                                            <input name="charismaSave" id="charismaSave" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Charisma Save -->

                                        <!-- Charisma Proficiency -->
                                        <input name="charismaSaveProficiency" value="0" type="hidden" />
                                        <input name="charismaSaveProficiency" id="charismaSaveProficiency" tabindex="20"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in CHA" />
                                        <!-- End Charisma Proficiency -->
                                    </li>
                                </ul>
                                <div class="label">
                                    Saving Throws
                                </div>
                            </div>
                            <!-- End Ability Saves -->

                            <!-- Skill Proficiencies -->
                            <div class="skills list-section box">
                                <ul>
                                    <li>
                                        <!-- Acrobatics Bonus -->
                                        <label for="Acrobatics">Acrobatics <span class="skill">(Dex)</span></label>
                                        <div id="acrobaticsDiv" class="skillMod skillDex">
                                            <input name="acrobatics" id="acrobatics" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Acrobatics Bonus -->

                                        <!-- Acrobatics Proficiency -->
                                        <input name="acrobaticsProficiency" value="0" type="hidden" />
                                        <input name="acrobaticsProficiency" id="acrobaticsProficiency" tabindex="21"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Acrobatics" />
                                        <!-- End Acrobatics Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Animal Handling Bonus -->
                                        <label for="animalHandling">Animal Handling <span
                                                class="skill">(Wis)</span></label>
                                        <div id="animalHandlingDiv" class="skillMod skillWis">
                                            <input name="animalHandling" id="animalHandling" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Animal Handling Bonus -->

                                        <!-- Animal Handling Proficiency -->
                                        <input name="animalHandlingProficiency" value="0" type="hidden" />
                                        <input name="animalHandlingProficiency" id="animalHandlingProficiency"
                                            tabindex="22" type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Animal Handling" />
                                        <!-- End Animal Handling Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Arcana Bonus -->
                                        <label for="arcana">Arcana <span class="skill">(Int)</span></label>
                                        <div id="arcanaDiv" class="skillMod skillInt">
                                            <input name="arcana" id="arcana" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Arcana Bonus -->

                                        <!-- Arcana Proficiency -->
                                        <input name="arcanaProficiency" value="0" type="hidden" />
                                        <input name="arcanaProficiency" id="arcanaProficiency" tabindex="23"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Arcana" />
                                        <!-- End Arcana Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Athletics Bonus -->
                                        <label for="athletics">Athletics <span class="skill">(Str)</span></label>
                                        <div id="athleticsDiv" class="skillMod skillStr">
                                            <input name="athletics" id="athletics" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Athletics Bonus -->

                                        <!-- Athletics Proficiency -->
                                        <input name="athleticsProficiency" value="0" type="hidden" />
                                        <input name="athleticsProficiency" id="athleticsProficiency" tabindex="24"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Athletics" />
                                        <!-- End Athletics Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Deception Bonus -->
                                        <label for="deception">Deception <span class="skill">(Cha)</span></label>
                                        <div id="deceptionDiv" class="skillMod skillCha">
                                            <input name="deception" id="deception" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Deception Bonus -->

                                        <!-- Deception Proficiency -->
                                        <input name="deceptionProficiency" value="0" type="hidden" />
                                        <input name="deceptionProficiency" id="deceptionProficiency" tabindex="25"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Deception" />
                                        <!-- End Deception Proficiency -->
                                    </li>
                                    <li>
                                        <!-- History Bonus -->
                                        <label for="history">History <span class="skill">(Int)</span></label>
                                        <div id="historyDiv" class="skillMod skillInt">
                                            <input name="history" id="history" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End History Bonus -->

                                        <!-- History Proficiency -->
                                        <input name="historyProficiency" value="0" type="hidden" />
                                        <input name="historyProficiency" id="historyProficiency" tabindex="26"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in History" />
                                        <!-- End History Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Insight Bonus -->
                                        <label for="insight">Insight <span class="skill">(Wis)</span></label>
                                        <div id="insightDiv" class="skillMod skillWis">
                                            <input name="insight" id="insight" value="+0" type="text" readonly />
                                        </div>
                                        <!-- EndInsight Bonus -->

                                        <!-- Insight Proficiency -->
                                        <input name="insightProficiency" value="0" type="hidden" />
                                        <input name="insightProficiency" id="insightProficiency" tabindex="27"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Insight" />
                                        <!-- End Insight Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Intimidation Bonus -->
                                        <label for="intimidation">Intimidation <span class="skill">(Cha)</span></label>
                                        <div id="intimidationDiv" class="skillMod skillCha">
                                            <input name="intimidation" id="intimidation" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Intimidation Bonus -->

                                        <!-- Intimidation Proficiency -->
                                        <input name="intimidationProficiency" value="0" type="hidden" />
                                        <input name="intimidationProficiency" id="intimidationProficiency" tabindex="28"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Intimidation" />
                                        <!-- End Intimidation Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Investigation Bonus -->
                                        <label for="investigation">Investigation <span
                                                class="skill">(Int)</span></label>
                                        <div id="investigationDiv" class="skillMod skillInt">
                                            <input name="investigation" id="investigation" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Investigation Bonus -->

                                        <!-- Investigation Proficiency -->
                                        <input name="investigationProficiency" value="0" type="hidden" />
                                        <input name="investigationProficiency" id="investigationProficiency"
                                            tabindex="29" type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Investigation" />
                                        <!-- End Investigation Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Medicine Bonus -->
                                        <label for="medicine">Medicine <span class="skill">(Wis)</span></label>
                                        <div id="medicineDiv" class="skillMod skillWis">
                                            <input name="medicine" id="medicine" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Medicine Bonus -->

                                        <!-- Medicine Proficiency -->
                                        <input name="medicineProficiency" value="0" type="hidden" />
                                        <input name="medicineProficiency" id="medicineProficiency" tabindex="30"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Medicine" />
                                        <!-- End Medicine Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Nature Bonus -->
                                        <label for="nature">Nature <span class="skill">(Int)</span></label>
                                        <div id="natureDiv" class="skillMod skillInt">
                                            <input name="nature" id="nature" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Nature Bonus -->

                                        <!-- Nature Proficiency -->
                                        <input name="natureProficiency" value="0" type="hidden" />
                                        <input name="natureProficiency" id="natureProficiency" tabindex="31"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Nature" />
                                        <!-- End Nature Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Perception Bonus -->
                                        <label for="perception">Perception <span class="skill">(Wis)</span></label>
                                        <div id="perceptionDiv" class="skillMod skillWis">
                                            <input name="perception" id="perception" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Perception Bonus -->

                                        <!-- Perception Proficiency -->
                                        <input name="perceptionProficiency" value="0" type="hidden" />
                                        <input name="perceptionProficiency" id="perceptionProficiency" tabindex="32"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Perception" />
                                        <!-- End Perception Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Performance Bonus -->
                                        <label for="performance">Performance <span class="skill">(Cha)</span></label>
                                        <div id="performanceDiv" class="skillMod skillCha">
                                            <input name="performance" id="performance" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Performance Bonus -->

                                        <!-- Performance Proficiency -->
                                        <input name="performanceProficiency" value="0" type="hidden" />
                                        <input name="performanceProficiency" id="performanceProficiency" tabindex="33"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Performance" />
                                        <!-- End Performance Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Persuasion Bonus -->
                                        <label for="persuasion">Persuasion <span class="skill">(Cha)</span></label>
                                        <div id="persuasionDiv" class="skillMod skillCha">
                                            <input name="persuasion" id="persuasion" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Persuasion Bonus -->

                                        <!-- Persuasion Proficiency -->
                                        <input name="persuasionProficiency" value="0" type="hidden" />
                                        <input name="persuasionProficiency" id="persuasionProficiency" tabindex="34"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Persuasion" />
                                        <!-- Persuasion Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Religion Bonus -->
                                        <label for="religion">Religion <span class="skill">(Int)</span></label>
                                        <div id="religionDiv" class="skillMod skillInt">
                                            <input name="religion" id="religion" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Religion Bonus -->

                                        <!-- Religion Proficiency -->
                                        <input name="religionProficiency" value="0" type="hidden" />
                                        <input name="religionProficiency" id="religionProficiency" tabindex="35"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Religion" />
                                        <!-- End Religion Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Sleight of Hand Bonus -->
                                        <label for="sleightOfHand">Sleight of Hand <span
                                                class="skill">(Dex)</span></label>
                                        <div id="sleightOfHandDiv" class="skillMod skillDex">
                                            <input name="sleightOfHand" id="sleightOfHand" value="+0" type="text"
                                                readonly />
                                        </div>
                                        <!-- End Sleight of Hand Bonus -->

                                        <!-- Sleight of Hand Proficiency -->
                                        <input name="sleightOfHandProficiency" value="0" type="hidden" />
                                        <input name="sleightOfHandProficiency" id="sleightOfHandProficiency"
                                            tabindex="36" type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Sleight of Hand" />
                                        <!-- End Sleight of Hand Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Stealth Bonus -->
                                        <label for="stealth">Stealth <span class="skill">(Dex)</span></label>
                                        <div id="stealthDiv" class="skillMod skillDex">
                                            <input name="stealth" id="stealth" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Stealth Bonus -->

                                        <!-- Stealth Proficiency -->
                                        <input name="stealthProficiency" value="0" type="hidden" />
                                        <input name="stealthProficiency" id="stealthProficiency" tabindex="37"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Stealth" />
                                        <!-- End Stealth Proficiency -->
                                    </li>
                                    <li>
                                        <!-- Survival Bonus -->
                                        <label for="survival">Survival <span class="skill">(Wis)</span></label>
                                        <div id="survivalDiv" class="skillMod skillWis">
                                            <input name="survival" id="survival" value="+0" type="text" readonly />
                                        </div>
                                        <!-- End Survival Bonus -->

                                        <!-- Survival Proficiency -->
                                        <input name="survivalProficiency" value="0" type="hidden" />
                                        <input name="survivalProficiency" id="survivalProficiency" tabindex="38"
                                            type="checkbox" data-toggle="tooltip"
                                            title="Check box if proficient in Survival" />
                                        <!-- End Survival Proficiency -->
                                    </li>
                                </ul>
                                <div class="label">
                                    Skills
                                </div>
                            </div>
                            <!-- End Skill Proficiencies -->
                        </div>
                        <!-- End Attribute Applications -->
                    </section>
                    <!-- Passive Perception -->
                    <div class="passivePerception box">
                        <div class="label-container">
                            <label for="passiveperception">Passive Wisdom (Perception)</label>
                        </div>
                        <div id="passivePerceptionDiv">
                            <input name="passivePerception" id="passivePerception" value="+10" readonly />
                        </div>
                    </div>
                    <!-- End Passive Perception -->

                    <!-- Other Proficiencies -->
                    <div class="otherProficiencies box textblock">
                        <label for="otherProficiencies" id="otherProficienciesLabel">Other Proficiencies and
                            Languages</label>
                        <textarea name="otherProficiencies" id="otherProficiencies" tabindex="39" data-toggle="tooltip"
                            title="Enter your character's other proficiencies and languages"></textarea>
                    </div>
                    <!-- End Other Proficiencies -->

                </section>
                <!-- End Character Sheet Column 1 -->

                <!-- Character Sheet Column 2 -->
                <section>

                    <!-- Combat Section -->
                    <section class="combat">

                        <!-- Armor Class -->
                        <div class="armorclass">
                            <div>
                                <label for="armorClass">Armor Class</label><input name="armorClass" id="armorClass"
                                    placeholder="10" tabindex="40" data-toggle="tooltip"
                                    title="Enter your character's AC" type="text" />
                            </div>
                        </div>
                        <!-- End Armor Class -->

                        <!-- Initiative -->
                        <div class="initiative">
                            <div>
                                <label for="initiative">Initiative</label><input name="initiative" id="initiative"
                                    placeholder="+0" tabindex="41" data-toggle="tooltip"
                                    title="Enter your character's initiative" type="text" />
                            </div>
                        </div>
                        <!-- End Initiative -->

                        <!-- Speed -->
                        <div class="speed">
                            <div>
                                <label for="speed">Speed</label><input name="speed" id="speed" placeholder="30"
                                    tabindex="42" data-toggle="tooltip" title="Enter your character's walking speed"
                                    type="text" />
                            </div>
                        </div>
                        <!-- End Speed -->

                        <!-- Hit Points -->
                        <div class="hp">
                            <!-- Regular Hit Points -->
                            <div class="regular">
                                <!-- Max Hit Points -->
                                <div class="max">
                                    <label for="maxHitPoints">Hit Point Maximum</label>
                                    <input name="maxHitPoints" id="maxHitPoints" placeholder="10" tabindex="43"
                                        data-toggle="tooltip" title="Enter your character's Max HP" type="text" />
                                </div>
                                <!-- End Max Hit Points -->

                                <!-- Current Hit Points -->
                                <div class="current">
                                    <label for="currentHitPoints">Current Hit Points</label>
                                    <input name="currentHitPoints" id="currentHitPoints" tabindex="44"
                                        data-toggle="tooltip" title="Enter your character's Current HP" type="text" />
                                </div>
                                <!-- End Current Hit Points -->
                            </div>
                            <!-- End Regular Hit Points -->

                            <!-- Temporary Hit Points -->
                            <div class="temporary">
                                <label for="temporaryHitPoints">Temporary Hit Points</label>
                                <input name="temporaryHitPoints" id="temporaryHitPoints" tabindex="45"
                                    data-toggle="tooltip" title="Enter your character's Temp HP" type="text" />
                            </div>
                            <!-- End Temporary Hit Points -->
                        </div>
                        <!-- End Hit Points -->

                        <!-- Hit Dice -->
                        <div class="hitdice">
                            <div>
                                <!-- Total Hit Dice -->
                                <div class="total">
                                    <label for="totalHitDice">Total</label><input name="totalHitDice" id="totalHitDice"
                                        placeholder="2d10" tabindex="46" data-toggle="tooltip"
                                        title="Enter your character's Total Hit Dice" type="text" />
                                </div>
                                <!-- End Total Hit Dice -->

                                <!-- Remaining Hit Dice -->
                                <div class="remaining">
                                    <label for="remainingHitDice">Hit Dice</label><input name="remainingHitDice"
                                        id="remainingHitDice" tabindex="47" data-toggle="tooltip"
                                        title="Enter your character's Remaining Hit Dice" type="text" />
                                </div>
                                <!-- End Remaining Hit Dice -->
                            </div>
                        </div>
                        <!-- End Hit Dice -->

                        <!-- Death Saves -->
                        <div class="deathsaves">
                            <div>
                                <div class="label">
                                    <label>Death Saves</label>
                                </div>
                                <div class="marks">
                                    <!-- Death Successes -->
                                    <div class="deathsuccesses">
                                        <label>Successes</label>
                                        <div class="bubbles">
                                            <!-- Death Success 1 -->
                                            <input name="deathSuccess1" value="0" type="hidden" />
                                            <input name="deathSuccess1" id="deathSuccess1" tabindex="48"
                                                data-toggle="tooltip" title="Check box if 1 death save success"
                                                type="checkbox" />
                                            <!-- End Death Success 1 -->

                                            <!-- Death Success 2 -->
                                            <input name="deathSuccess2" value="0" type="hidden" />
                                            <input name="deathSuccess2" id="deathSuccess2" tabindex="49"
                                                data-toggle="tooltip" title="Check box if 2 death save successes"
                                                type="checkbox" />
                                            <!-- End Death Success 2 -->

                                            <!-- Death Success 3 -->
                                            <input name="deathSuccess3" value="0" type="hidden" />
                                            <input name="deathSuccess3" id="deathSuccess3" tabindex="50"
                                                data-toggle="tooltip" title="Check box if 3 death save successes"
                                                type="checkbox" />
                                            <!-- End Death Success 3 -->
                                        </div>
                                    </div>
                                    <!-- End Death Successes -->

                                    <!-- Death Failures -->
                                    <div class="deathfails">
                                        <label>Failures</label>
                                        <div class="bubbles">
                                            <!-- Death Fail 1 -->
                                            <input name="deathFail1" value="0" type="hidden" />
                                            <input name="deathFail1" id="deathFail1" tabindex="51" data-toggle="tooltip"
                                                title="Check box if 1 death save failure" type="checkbox" />
                                            <!-- End Death Fail 1 -->

                                            <!-- Death Fail 2 -->
                                            <input name="deathFail2" value="0" type="hidden" />
                                            <input name="deathFail2" id="deathFail2" tabindex="52" data-toggle="tooltip"
                                                title="Check box if 2 death save failures" type="checkbox" />
                                            <!-- End Death Fail 2 -->

                                            <!-- Death Fail 3 -->
                                            <input name="deathFail3" value="0" type="hidden" />
                                            <input name="deathFail3" id="deathFail3" tabindex="53" data-toggle="tooltip"
                                                title="Check box if 3 death save failures" type="checkbox" />
                                            <!-- End Death Fail 3 -->
                                        </div>
                                    </div>
                                    <!-- End Death Failures -->
                                </div>
                            </div>
                        </div>
                        <!-- End Death Saves -->
                    </section>
                    <!-- End Combat Section -->

                    <!-- Attacks and Spellcasting -->
                    <section class="attacksandspellcasting">
                        <div>
                            <label>Attacks &amp; Spellcasting</label>

                            <!-- Attack Table -->
                            <table>
                                <thead>
                                    <!-- Attack Table Headers -->
                                    <tr>
                                        <th>Name</th>
                                        <th>Atk Bonus</th>
                                        <th>Damage/Type</th>
                                    </tr>
                                    <!-- End Attack Table Headers -->
                                </thead>
                                <tbody>
                                    <!-- Attack 1 -->
                                    <tr>
                                        <!-- Attack Name 1 -->
                                        <td><input name="attackName1" id="attackName1" tabindex="54"
                                                data-toggle="tooltip" title="Enter attack name" type="text" /></td>
                                        <!-- End Attack Name 1 -->

                                        <!-- Attack Bonus 1 -->
                                        <td><input name="attackBonus1" id="attackBonus1" tabindex="55"
                                                data-toggle="tooltip" title="Enter attack bonus" type="text" /></td>
                                        <!-- End Attack Bonus 1 -->

                                        <!-- Attack Damage 1 -->
                                        <td><input name="attackDamage1" id="attackDamage1" tabindex="56"
                                                data-toggle="tooltip" title="Enter attack damage" type="text" /></td>
                                        <!-- End Attack Damage 1 -->
                                    </tr>
                                    <!-- End Attack 1 -->

                                    <!-- Attack 2 -->
                                    <tr>
                                        <!-- Attack Name 2 -->
                                        <td><input name="attackName2" id="attackName2" tabindex="57"
                                                data-toggle="tooltip" title="Enter attack name" type="text" /></td>
                                        <!-- End Attack Name 2 -->

                                        <!-- Attack Bonus 2 -->
                                        <td><input name="attackBonus2" id="attackBonus2" tabindex="58"
                                                data-toggle="tooltip" title="Enter attack bonus" type="text" /></td>
                                        <!-- End Attack Bonus 2 -->

                                        <!-- Attack Damage 2 -->
                                        <td><input name="attackDamage2" id="attackDamage2" tabindex="59"
                                                data-toggle="tooltip" title="Enter attack damage" type="text" /></td>
                                        <!-- End Attack Damage 2 -->
                                    </tr>
                                    <!-- End Attack 2 -->

                                    <!-- Attack 3 -->
                                    <tr>
                                        <!-- Attack Name 3 -->
                                        <td><input name="attackName3" id="attackName3" tabindex="60"
                                                data-toggle="tooltip" title="Enter attack name" type="text" /></td>
                                        <!-- End Attack Name 3 -->

                                        <!-- Attack Bonus 3 -->
                                        <td><input name="attackBonus3" id="attackBonus3" tabindex="61"
                                                data-toggle="tooltip" title="Enter attack bonus" type="text" /></td>
                                        <!-- Attack Bonus 3 -->

                                        <!-- Attack Damage 3 -->
                                        <td><input name="attackDamage3" id="attackDamage3" tabindex="62"
                                                data-toggle="tooltip" title="Enter attack damage" type="text" /></td>
                                        <!-- End Attack Damage 2 -->
                                    </tr>
                                </tbody>
                            </table>
                            <!-- End Attack Table -->

                            <!-- Spellcasting -->
                            <textarea name="spellcasting" id="spellcasting" tabindex="63" data-toggle="tooltip"
                                title="Enter additional attacks and spellcasting info"></textarea>
                            <!-- End Spellcasting -->
                        </div>
                    </section>
                    <!-- End Attacks and Spellcasting -->

                    <!-- Equipment and Treasure -->
                    <section class="equipment">
                        <div>
                            <label>Equipment</label>

                            <!-- Treasure -->
                            <div class="money">
                                <ul>
                                    <li>
                                        <!-- Copper Pieces -->
                                        <label for="copperPieces">cp</label>
                                        <input name="copperPieces" id="copperPieces" tabindex="64" data-toggle="tooltip"
                                            title="Enter your character's copper pieces" />
                                        <!-- End Copper Pieces -->
                                    </li>

                                    <li>
                                        <!-- Silver Pieces -->
                                        <label for="silverPieces">sp</label>
                                        <input name="silverPieces" id="silverPieces" tabindex="65" data-toggle="tooltip"
                                            title="Enter your character's silver pieces" />
                                        <!-- End Silver Pieces -->
                                    </li>

                                    <li>
                                        <!-- Electrum Pieces -->
                                        <label for="electrumPieces">ep</label>
                                        <input name="electrumPieces" id="electrumPieces" tabindex="66"
                                            data-toggle="tooltip" title="Enter your character's electrum pieces" />
                                        <!-- End Electrum Pieces -->
                                    </li>
                                    <li>
                                        <!-- Gold Pieces -->
                                        <label for="goldPieces">gp</label>
                                        <input name="goldPieces" id="goldPieces" tabindex="67" data-toggle="tooltip"
                                            title="Enter your character's gold pieces" />
                                        <!-- End Gold Pieces -->
                                    </li>
                                    <li>
                                        <!-- Platinum Pieces -->
                                        <label for="platinumPieces">pp</label>
                                        <input name="platinumPieces" id="platinumPieces" tabindex="68"
                                            data-toggle="tooltip" title="Enter your character's platinum pieces" />
                                        <!-- End Platinum Pieces -->
                                    </li>
                                </ul>
                            </div>
                            <!-- End Treasure -->

                            <!-- Equipment -->
                            <textarea name="equipment" id="equipment" placeholder="Equipment list here" tabindex="69"
                                data-toggle="tooltip" title="Enter your character's equipment"></textarea>
                            <!-- End Equipment -->
                        </div>
                    </section>
                    <!-- End Equipment and Treasure -->

                </section>
                <!-- End Character Sheet Column 2 -->

                <!-- Character Sheet Column 3 -->
                <section>

                    <!-- Flavor -->
                    <section class="flavor">

                        <!-- Personality -->
                        <div class="personality">
                            <label for="personality">Personality</label>
                            <textarea name="personality" id="personality" tabindex="70" data-toggle="tooltip"
                                title="Enter your character's personality traits"></textarea>
                        </div>
                        <!-- End Personality -->

                        <!-- Ideals -->
                        <div class="ideals">
                            <label for="ideals">Ideals</label>
                            <textarea name="ideals" id="ideals" tabindex="71" data-toggle="tooltip"
                                title="Enter your character's ideals"></textarea>
                        </div>
                        <!-- End Ideals -->

                        <!-- Bonds -->
                        <div class="bonds">
                            <label for="bonds">Bonds</label>
                            <textarea name="bonds" id="bonds" tabindex="72" data-toggle="tooltip"
                                title="Enter your character's bonds"></textarea>
                        </div>
                        <!-- End Bonds -->

                        <!-- Flaws -->
                        <div class="flaws">
                            <label for="flaws">Flaws</label>
                            <textarea name="flaws" id="flaws" tabindex="73" data-toggle="tooltip"
                                title="Enter your character's flaws"></textarea>
                        </div>
                        <!-- End Flaws -->

                    </section>
                    <!-- End Flavor -->

                    <!-- Features -->
                    <section class="features">
                        <div>
                            <label for="features">Features &amp; Traits</label>
                            <textarea name="features" id="features" tabindex="74" data-toggle="tooltip"
                                title="Enter your character's features"></textarea>
                        </div>
                    </section>
                    <!-- End Features -->

                </section>
                <!-- End Character Sheet Column 3 -->

            </div>
            <!-- End Character Sheet Body -->

            <!-- Submit Button -->
            <div class="submitButtons">
                <input type="submit" value="Update Character" />
            </div>
            <!-- End Submit Button -->

        </form>
        <!-- End Character Sheet Form -->

    </main>
    <!-- End Main Content -->

    <!-- Footer -->
    <footer id="footer">
        <p class="copyright"></p>
    </footer>
    <!-- End Footer -->

    <!-- Ajax Calls -->
    <script type="text/javascript" src="<?= $ROOT ?>/js/abilityModifier.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>/js/proficiencyBonus.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>/js/saveBonus.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>/js/skillBonus.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>/js/passivePerception.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>/js/eventHandlers.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>/js/getCharacter.js"></script>

</body>

</html>



<!-- Close Database Connection -->
<?php
$pdo = null;
ob_end_flush();
?>
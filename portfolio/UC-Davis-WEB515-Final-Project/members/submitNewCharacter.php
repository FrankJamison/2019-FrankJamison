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
require_once('../includes/functions.inc.php');
require_once('../includes/session.inc.php');

// Member Username
$memberUsername = $_SESSION['memberUsername'];

try {
    // Connect to database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $web_user, $pwd);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set local variables
    $characterName = $_POST["characterName"];
    $classID = $_POST["characterClass"];
    $levelID = $_POST["characterLevel"];
    $backgroundID = $_POST["characterBackground"];
    $userID = $_POST["playerName"];
    $raceID = $_POST["characterRace"];
    $alignmentID = $_POST["characterAlignment"];
    $experiencePoints = intval($_POST["experiencePoints"]);
    $strengthScore = intval($_POST["strengthScore"]);
    $dexterityScore = intval($_POST["dexterityScore"]);
    $constitutionScore = intval($_POST["constitutionScore"]);
    $intelligenceScore = intval($_POST["intelligenceScore"]);
    $wisdomScore = intval($_POST["wisdomScore"]);
    $charismaScore = intval($_POST["charismaScore"]);
    $inspiration = $_POST["inspiration"];
    $strengthProficiency = $_POST["strengthSaveProficiency"];
    $strengthProficiency = ($strengthProficiency) ? 1 : 0;
    $dexterityProficiency = $_POST["dexteritySaveProficiency"];
    $dexterityProficiency = ($dexterityProficiency) ? 1 : 0;
    $constitutionProficiency = $_POST["constitutionSaveProficiency"];
    $constitutionProficiency = ($constitutionProficiency) ? 1 : 0;
    $intelligenceProficiency = $_POST["intelligenceSaveProficiency"];
    $intelligenceProficiency = ($intelligenceProficiency) ? 1 : 0;
    $wisdomProficiency = $_POST["wisdomSaveProficiency"];
    $wisdomProficiency = ($wisdomProficiency) ? 1 : 0;
    $charismaProficiency = $_POST["charismaSaveProficiency"];
    $charismaProficiency = ($charismaProficiency) ? 1 : 0;
    $acrobaticsProficiency = $_POST["acrobaticsProficiency"];
    $acrobaticsProficiency = ($acrobaticsProficiency) ? 1 : 0;
    $animalHandlingProficiency = $_POST["animalHandlingProficiency"];
    $animalHandlingProficiency = ($animalHandlingProficiency) ? 1 : 0;
    $arcanaProficiency = $_POST["arcanaProficiency"];
    $arcanaProficiency = ($arcanaProficiency) ? 1 : 0;
    $athleticsProficiency = $_POST["athleticsProficiency"];
    $athleticsProficiency = ($athleticsProficiency) ? 1 : 0;
    $deceptionProficiency = $_POST["deceptionProficiency"];
    $deceptionProficiency = ($deceptionProficiency) ? 1 : 0;
    $historyProficiency = $_POST["historyProficiency"];
    $historyProficiency = ($historyProficiency) ? 1 : 0;
    $insightProficiency = $_POST["insightProficiency"];
    $insightProficiency = ($insightProficiency) ? 1 : 0;
    $intimidationProficiency = $_POST["intimidationProficiency"];
    $intimidationProficiency = ($intimidationProficiency) ? 1 : 0;
    $investigationProficiency = $_POST["investigationProficiency"];
    $investigationProficiency = ($investigationProficiency) ? 1 : 0;
    $medicineProficiency = $_POST["medicineProficiency"];
    $medicineProficiency = ($medicineProficiency) ? 1 : 0;
    $natureProficiency = $_POST["natureProficiency"];
    $natureProficiency = ($natureProficiency) ? 1 : 0;
    $perceptionProficiency = $_POST["perceptionProficiency"];
    $perceptionProficiency = ($perceptionProficiency) ? 1 : 0;
    $performanceProficiency = $_POST["performanceProficiency"];
    $performanceProficiency = ($performanceProficiency) ? 1 : 0;
    $persuasionProficiency = $_POST["persuasionProficiency"];
    $persuasionProficiency = ($persuasionProficiency) ? 1 : 0;
    $religionProficiency = $_POST["religionProficiency"];
    $religionProficiency = ($religionProficiency) ? 1 : 0;
    $sleightOfHandProficiency = $_POST["sleightOfHandProficiency"];
    $sleightOfHandProficiency = ($sleightOfHandProficiency) ? 1 : 0;
    $stealthProficiency = $_POST["stealthProficiency"];
    $stealthProficiency = ($stealthProficiency) ? 1 : 0;
    $survivalProficiency = $_POST["survivalProficiency"];
    $survivalProficiency = ($survivalProficiency) ? 1 : 0;
    $otherProficiencies = htmlspecialchars($_POST["otherProficiencies"], ENT_QUOTES);
    $armorClass = intval($_POST["armorClass"]);
    $initiative = intval($_POST["initiative"]);
    $speed = intval($_POST["speed"]);
    $maxHitPoints = intval($_POST["maxHitPoints"]);
    $currentHitPoints = intval($_POST["currentHitPoints"]);
    $temporaryHitPoints = intval($_POST["temporaryHitPoints"]);
    $totalHitDice = $_POST["totalHitDice"];
    $remainingHitDice = $_POST["remainingHitDice"];
    $deathSuccess1 = $_POST["deathSuccess1"];
    $deathSuccess1 = ($deathSuccess1) ? 1 : 0;
    $deathSuccess2 = $_POST["deathSuccess2"];
    $deathSuccess2 = ($deathSuccess2) ? 1 : 0;
    $deathSuccess3 = $_POST["deathSuccess3"];
    $deathSuccess3 = ($deathSuccess3) ? 1 : 0;
    $deathFail1 = $_POST["deathFail1"];
    $deathFail1 = ($deathFail1) ? 1 : 0;
    $deathFail2 = $_POST["deathFail2"];
    $deathFail2 = ($deathFail2) ? 1 : 0;
    $deathFail3 = $_POST["deathFail3"];
    $deathFail3 = ($deathFail3) ? 1 : 0;
    $attackName1 = $_POST["attackName1"];
    $attackBonus1 = $_POST["attackBonus1"];
    $attackDamage1 = $_POST["attackDamage1"];
    $attackName2 = $_POST["attackName2"];
    $attackBonus2 = $_POST["attackBonus2"];
    $attackDamage2 = $_POST["attackDamage2"];
    $attackName3 = $_POST["attackName3"];
    $attackBonus3 = $_POST["attackBonus3"];
    $attackDamage3 = $_POST["attackDamage3"];
    $spellcasting = htmlspecialchars($_POST["spellcasting"], ENT_QUOTES);
    $copperPieces = intval($_POST["copperPieces"]);
    $silverPieces = intval($_POST["silverPieces"]);
    $electrumPieces = intval($_POST["electrumPieces"]);
    $goldPieces = intval($_POST["goldPieces"]);
    $platinumPieces = intval($_POST["platinumPieces"]);
    $equipment = htmlspecialchars($_POST["equipment"], ENT_QUOTES);
    $personality = htmlspecialchars($_POST["personality"], ENT_QUOTES);
    $ideals = htmlspecialchars($_POST["ideals"], ENT_QUOTES);
    $bonds = htmlspecialchars($_POST["bonds"], ENT_QUOTES);
    $flaws = htmlspecialchars($_POST["flaws"], ENT_QUOTES);
    $features = htmlspecialchars($_POST["features"], ENT_QUOTES);

    /* NOTE the use of htmlspecialchars for text fields  to remove quotes. This is to keep the sql from breaking */

    $sql = "INSERT INTO characters (
        characterName,
        classID,
        levelID,
        backgroundID,
        userID,
        raceID,
        alignmentID,
        experiencePoints,
        strengthScore,
        dexterityScore,
        constitutionScore,
        intelligenceScore,
        wisdomScore,
        charismaScore,
        inspiration,
        strengthProficiency,
        dexterityProficiency,
        constitutionProficiency,
        intelligenceProficiency,
        wisdomProficiency,
        charismaProficiency,
        acrobaticsProficiency,
        animalHandlingProficiency,
        arcanaProficiency,
        athleticsProficiency,
        deceptionProficiency,
        historyProficiency,
        insightProficiency,
        intimidationProficiency,
        investigationProficiency,
        medicineProficiency,
        natureProficiency,
        perceptionProficiency,
        performanceProficiency,
        persuasionProficiency,
        religionProficiency,
        sleightOfHandProficiency,
        stealthProficiency,
        survivalProficiency,
        otherProficiencies,
        armorClass,
        initiative,
        speed,
        maxHitPoints,
        currentHitPoints,
        temporaryHitPoints,
        totalHitDice,
        remainingHitDice,
        deathSuccess1,
        deathSuccess2,
        deathSuccess3,
        deathFail1,
        deathFail2,
        deathFail3,
        attackName1,
        attackBonus1,
        attackDamage1,
        attackName2,
        attackBonus2,
        attackDamage2,
        attackName3,
        attackBonus3,
        attackDamage3,
        spellcasting,
        copperPieces,
        silverPieces,
        electrumPieces,
        goldPieces,
        platinumPieces,
        equipment,
        personality,
        ideals,
        bonds,
        flaws,
        features
    ) VALUES (
        '$characterName',
        '$classID',
        '$levelID',
        '$backgroundID',
        '$userID',
        '$raceID',
        '$alignmentID',
        '$experiencePoints',
        '$strengthScore',
        '$dexterityScore',
        '$constitutionScore',
        '$intelligenceScore',
        '$wisdomScore',
        '$charismaScore',
        '$inspiration',
        '$strengthProficiency',
        '$dexterityProficiency',
        '$constitutionProficiency',
        '$intelligenceProficiency',
        '$wisdomProficiency',
        '$charismaProficiency',
        '$acrobaticsProficiency',
        '$animalHandlingProficiency',
        '$arcanaProficiency',
        '$athleticsProficiency',
        '$deceptionProficiency',
        '$historyProficiency',
        '$insightProficiency',
        '$intimidationProficiency',
        '$investigationProficiency',
        '$medicineProficiency',
        '$natureProficiency',
        '$perceptionProficiency',
        '$performanceProficiency',
        '$persuasionProficiency',
        '$religionProficiency',
        '$sleightOfHandProficiency',
        '$stealthProficiency',
        '$survivalProficiency',
        '$otherProficiencies',
        '$armorClass',
        '$initiative',
        '$speed',
        '$maxHitPoints',
        '$currentHitPoints',
        '$temporaryHitPoints',
        '$totalHitDice',
        '$remainingHitDice',
        '$deathSuccess1',
        '$deathSuccess2',
        '$deathSuccess3',
        '$deathFail1',
        '$deathFail2',
        '$deathFail3',
        '$attackName1',
        '$attackBonus1',
        '$attackDamage1',
        '$attackName2',
        '$attackBonus2',
        '$attackDamage2',
        '$attackName3',
        '$attackBonus3',
        '$attackDamage3',
        '$spellcasting',
        '$copperPieces',
        '$silverPieces',
        '$electrumPieces',
        '$goldPieces',
        '$platinumPieces',
        '$equipment',
        '$personality',
        '$ideals',
        '$bonds',
        '$flaws',
        '$features'
    )";

    // use exec() because no results are returned
    $conn->exec($sql);

    $displaySuccess = true;
} catch (PDOException $e) {

    $displaySuccess = false;

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quest Keeper - A D&amp;D Character Database - Member Area</title>
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
                &nbsp;
            </div>
            <div class="clearfix"></div>
            <!-- End Right Header Login Form -->

            <!-- Main Navagation -->
            <div class="w3_navigation">
                <div class="container">
                    <nav class="navbar navbar-default">
                        <div class="left-navigation">
                            &nbsp;
                        </div>
                        <div class="center-navigation">
                            <h1><a href="<?= $ROOT ?>/members/index.php"><span>Quest Keeper</span></a></h1>
                        </div>
                        <div class="right-navigation">
                            &nbsp;
                        </div>
                    </nav>
                </div>
            </div>
            <!-- End Main Navagation -->
        </div>
    </header>

    <!-- Main Content -->
    <main id="content">

        <!-- If successfully added show success screen -->
        <?php if ($displaySuccess) { ?>
            <div class="title-info">
                <h4><?= $characterName; ?> </h4>
                <p>Has successfully been added to the database</p>
            </div>
            <?php header("Refresh: 8; $ROOT/members/index.php");
        } else { ?>
            <!-- Else show fail screen -->
            <div class="title-info">
                <h4><?= $characterName; ?> </h4>
                <p>Was not successfully added to the database</p>
                <p>&nbsp;</p>
            </div>
            <?php header("Refresh: 8; $ROOT/members/index.php");
        } ?>

    </main>
    <!-- End Main Content -->

    <!-- Footer -->
    <footer id="footer">
        <p class="copyright"></p>
    </footer>
    <!-- End Footer -->

    <!-- Ajax Calls -->
    <script type="text/javascript" src="<?= $ROOT ?>js/abilityModifier.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>js/proficiencyBonus.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>js/saveBonus.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>js/skillBonus.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>js/passivePerception.js"></script>
    <script type="text/javascript" src="<?= $ROOT ?>js/eventHandlers.js"></script>

</body>

</html>


<!-- Close Database Connection -->
<?php $pdo = null; ?>
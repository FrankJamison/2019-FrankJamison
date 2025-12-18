<?php
// Start and Check for Valid Session
require_once("../includes/session.inc.php");

// Include Functions
require_once("../includes/functions.inc.php");

// Debug Flag
$debug = true;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
$error_text = "\r";

// Variable Include
require_once("../includes/variables.inc.php");

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Graph Preprocessing
$numCustomers = countNumCustomers($dbc);
$creditLimitArray = fillCreditLimitArray($dbc);
$graphArray = fillGraphArray($creditLimitArray);
$graphName = "../charts/charts-$numCustomers.png";
$graphScale = makeGraphScale($numCustomers);
drawBarGraph(500, 400, $graphArray, $graphScale, $graphName);
?>

<!DOCTYPE HTML>
<html>

<!-- HTML Head Include -->
<?php require_once("../includes/memberhtmlhead.inc.php"); ?>

<body>
	<div id="main">

		<!-- Page Header -->
		<div id="header">

			<!-- Page Logo -->
			<?php require_once("../includes/logo.inc.php"); ?>

			<!-- Page Navigation -->
			<div id="menubar">
				<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="addcustomer.php">Add Customer</a></li>
					<li class="selected"><a href="creditlimits.php">Credit Limit Report</a></li>
					<li><a href="inventory.php">Product Inventory Report</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">
				<h2 class="graph">Customer Credit Limit Distribution Report</h2>
				<p class="graph"><img src="<?= $graphName ?>" alt="Credit Limit Distribution Report"></p>
			</div>

		</div>

		<!-- Page Footer -->
		<?php require_once("../includes/footer.inc.php"); ?>

	</div>
</body>

</html>

<?php
// Close Database Connection
mysqli_close($dbc);
?>
<?php

// Start and Check for Valid Session
require_once("../includes/session.inc.php");

// Variable and Function Includes
require_once("../includes/variables.inc.php");
require_once("../includes/functions.inc.php");

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
$error_text = "\r";

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Form display variable
$output_form = true;

// Input Variables
$productLine = '';

// Get Variables
$page = 1;
$limit = 10;
$offset = 0;


// If GET Parameters are set
if (isset($_GET["page"]) && isset($_GET["productLine"])) {

	// Get Variables
	$page = $_GET["page"];
	$productLine = urldecode($_GET["productLine"]);
	$offset = ($page - 1) * $limit;

	// Get Product Line Page Output
	$output = getProductList($dbc, $productLine, $limit, $offset);

	// Do not display form
	$output_form = false;

} else {

	// Set Variables
	$page = 1;
	$productLine = '';
}

// If POST parameters are set
if (isset($_POST['submit'])) { // data posted

	// Get Product Line
	$productLine = trim(mysqli_real_escape_string($dbc, $_POST['productLine']));

	// Get Product Line Page Output
	$output = getProductList($dbc, $productLine, $limit, $offset);

	// Do not display form
	$output_form = false;
}

// Options for Product Line Select
$query = "SELECT `productLine` FROM `productlines`";

// Do Not Add Null Value to Dropdown
$withNull = false;


// Get Product Line Options
$productLineOptions = getDropdownList($dbc, $query, 'productLine', $withNull);

// Encode Product Line
$productLineEncoded = urlencode($productLine);

// Pagination
$query = "SELECT * 
			FROM `products` 
			WHERE `productLine` = '$productLine'";
$result = mysqli_query($dbc, $query);
$totalRecords = mysqli_num_rows($result);
$totalPages = ceil($totalRecords / $limit);

$pageLinks = pagination($result, $page, $totalPages, $productLineEncoded);
?>

<!DOCTYPE HTML>
<html>

<?php require_once("../includes/memberhtmlhead.inc.php"); ?>

<body>
	<div id="main">
		<div id="header">

			<!-- Page Logo -->
			<?php require_once("../includes/logo.inc.php"); ?>

			<div id="menubar">
				<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="addcustomer.php">Add Customer</a></li>
					<li><a href="creditlimits.php">Credit Limit Report</a></li>
					<li class="selected"><a href="inventory.php">Product Inventory Report</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<div id="content">
				<!-- Form Output -->
				<?php if ($output_form) { ?>

					<h2>Product Inventory Report Request</h2>

					<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

						<table>
							<tr>
								<td>Please select a product line: </td>
								<td>
									<?= $productLineOptions ?>
								</td>
							</tr>
						</table>

						<input name="submit" id="submit" type="submit">
					</form>
				<?php } else { ?>
					<h2>Product Inventory Report for <?= $productLine ?>, Page <?= $page ?> of <?= $totalPages ?></h2>
					<?= $pageLinks ?>
					<br><br>
					<hr><br>

					<?= $output ?>
					<?= $pageLinks ?>
				<?php } ?>

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
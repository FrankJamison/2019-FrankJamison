<?php

// Start and Check for Valid Session
require_once("../includes/session.inc.php");

// Include Functions
require_once("../includes/functions.inc.php");

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '0');
$error_text = "\r";

// Variable Include
require_once("../includes/variables.inc.php");

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Form display variable
$output_form = true;

// Form Input Variables
$customerName = '';
$contactLastName = '';
$contactFirstName = '';
$phone = '';
$addressLine1 = '';
$addressLine2 = '';
$city = '';
$state = '';
$postalCode = '';
$country = '';
$salesRepEmployeeNumber = '';
$creditLimit = '';
$username = '';
$password = '';
$md5hashpwd = '';
$email = '';

// Validated Input Variables
$validCustomerName = '';
$validContactLastName = '';
$validContactFirstName = '';
$validPhone = '';
$validAddressLine1 = '';
$validAddressLine2 = '';
$validCity = '';
$validState = '';
$validPostalCode = '';
$validCountry = '';
$validSalesRepEmployeeNumber = '';
$validCreditLimit = '';
$validUsername = '';
$validPassword = '';
$validEmail = '';

//RegEx Patterns
$regExCustomerName = '/^[a-zA-Z0-9 ]{2,50}$/';
$regExContactLastName = '/^[a-zA-Z]{2,15}$/';
$regExContactFirstName = '/^[a-zA-Z]{2,15}$/';
$regExPhone = '/^\(\d{3}\)[ ]{1}\d{3}-\d{4}$/';
$regExAddressLine1 = '/^[a-zA-Z0-9\. ]{2,50}$/';
$regExAddressLine2 = '/^[a-zA-Z0-9 ]{2,50}$/';
$regExCity = '/^[a-zA-Z ]{3,20}$/';
$regExState = '/^[a-zA-Z]{2}$/';
$regExPostalCode = '/^[0-9]{5}$/';
$regExCountry = '/^[a-zA-Z0-9 ]{2,50}$/';
$regExSalesRepEmployeeNumber = '/^\d{4}$/';
$regExCreditLimit = '/^[\d]{2,6}$/';
$regExUsername = '/^[a-zA-Z0-9#\?!@$%\^\&\*-]{2,50}$/';
$regExPassword = '/^[a-zA-Z0-9#\?!@$%\^\&\*-]{2,50}$/';
$regExEmail = '/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/';

if (isset($_POST['submit'])) { // data posted

	// If debug flag is set to true
	if ($debug) {

		// Display text input
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";

		// Display file input
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";

		// die("temp stop point");
	} // End debug only

	// Get Form Input
	$customerName = trim(mysqli_real_escape_string($dbc, $_POST['customerName']));
	$contactLastName = trim(mysqli_real_escape_string($dbc, $_POST['contactLastName']));
	$contactFirstName = trim(mysqli_real_escape_string($dbc, $_POST['contactFirstName']));
	$phone = trim(mysqli_real_escape_string($dbc, $_POST['phone']));
	$addressLine1 = trim(mysqli_real_escape_string($dbc, $_POST['addressLine1']));
	$addressLine2 = trim(mysqli_real_escape_string($dbc, $_POST['addressLine2']));
	$city = trim(mysqli_real_escape_string($dbc, $_POST['city']));
	$state = trim(mysqli_real_escape_string($dbc, $_POST['state']));
	$postalCode = trim(mysqli_real_escape_string($dbc, $_POST['postalCode']));
	$country = trim(mysqli_real_escape_string($dbc, $_POST['country']));
	$salesRepEmployeeNumber = trim(mysqli_real_escape_string($dbc, $_POST['salesRepEmployeeNumber']));
	$creditLimit = trim(mysqli_real_escape_string($dbc, $_POST['creditLimit']));
	$username = trim(mysqli_real_escape_string($dbc, $_POST['username']));
	$password = trim(mysqli_real_escape_string($dbc, $_POST['password']));
	$md5hashpwd = md5($password);
	$email = trim(mysqli_real_escape_string($dbc, $_POST['email']));

	// Check for Empty Fields
	if (
		empty($_POST['customerName']) ||
		empty($_POST['contactLastName']) ||
		empty($_POST['contactFirstName']) ||
		empty($_POST['phone']) ||
		empty($_POST['addressLine1']) ||
		empty($_POST['city']) ||
		empty($_POST['country']) ||
		empty($_POST['username']) ||
		empty($_POST['password']) ||
		empty($_POST['email'])
	) {

		// Display Error Text
		if (empty($_POST['customerName'])) {
			$error_text .= "\t\t\t\t\t<p>Customer Name is required.</p>\r";
		}


		if (empty($_POST['contactLastName'])) {
			$error_text .= "\t\t\t\t\t<p>Contact Last Name is required.</p>\r";
		}

		if (empty($_POST['contactFirstName'])) {
			$error_text .= "\t\t\t\t\t<p>Contact First Name is required.</p>\r";
		}

		if (empty($_POST['phone'])) {
			$error_text .= "\t\t\t\t\t<p>Phone Number is required.</p>\r";
		}

		if (empty($_POST['addressLine1'])) {
			$error_text .= "\t\t\t\t\t<p>Address Line 1 is required.</p>\r";
		}

		if (empty($_POST['city'])) {
			$error_text .= "\t\t\t\t\t<p>City is required.</p>\r";
		}

		if (empty($_POST['country'])) {
			$error_text .= "\t\t\t\t\t<p>Country is required.</p>\r";
		}

		if (empty($_POST['username'])) {
			$error_text .= "\t\t\t\t\t<p>Username is required.</p>\r";
		}

		if (empty($_POST['password'])) {
			$error_text .= "\t\t\t\t\t<p>Password is required.</p>\r";
		}

		if (empty($_POST['email'])) {
			$error_text .= "\t\t\t\t\t<p>Email is required.</p>\r";
		}

		// Display Form
		$output_form = true;

	} else { // All required fields have data

		// Validate Required Input
		$validCustomerName = fieldValidation($regExCustomerName, $customerName);
		$validContactLastName = fieldValidation($regExContactLastName, $contactLastName);
		$validContactFirstName = fieldValidation($regExContactFirstName, $contactFirstName);
		$validPhone = fieldValidation($regExPhone, $phone);
		$validAddressLine1 = fieldValidation($regExAddressLine1, $addressLine1);
		$validCity = fieldValidation($regExCity, $city);
		$validCountry = fieldValidation($regExCountry, $country);
		$validUsername = fieldValidation($regExUsername, $username);
		$validPassword = fieldValidation($regExPassword, $password);
		$validEmail = fieldValidation($regExEmail, $email);

		// Validate Optional Input. If Empty, set variable to single space to negate false values.
		if (empty($_POST['addressLine2'])) {
			$validAddressLine2 = ' ';
		} else {
			$validAddressLine2 = fieldValidation($regExAddressLine2, $addressLine2);
		}

		if (empty($_POST['state'])) {
			$validState = ' ';
		} else {
			$validState = fieldValidation($regExState, $state);
		}

		if (empty($_POST['postalCode'])) {
			$validPostalCode = ' ';
		} else {
			$validPostalCode = fieldValidation($regExPostalCode, $postalCode);
		}

		if (empty($_POST['salesRepEmployeeNumber'])) {
			$validSalesRepEmployeeNumber = ' ';
		} else {
			$validSalesRepEmployeeNumber = fieldValidation($regExSalesRepEmployeeNumber, $salesRepEmployeeNumber);
		}

		if (empty($_POST['creditLimit'])) {
			$validCreditLimit = ' ';
		} else {
			$validCreditLimit = fieldValidation($regExCreditLimit, $creditLimit);
		}

		// Check for false values
		if (
			$validCustomerName == false ||
			$validContactLastName == false ||
			$validContactFirstName == false ||
			$validPhone == false ||
			$validAddressLine1 == false ||
			$validAddressLine2 == false ||
			$validCity == false ||
			$validState == false ||
			$validPostalCode == false ||
			$validCountry == false ||
			$validSalesRepEmployeeNumber == false ||
			$validCreditLimit == false ||
			$validUsername == false ||
			$validPassword == false ||
			$validEmail == false
		) {

			// Display Error Text
			if ($validCustomerName == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Customer Name</em> between 2 and 50 characters.</p>\r";
			}

			if ($validContactLastName == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Contact Last Name</em> between 2 and 15 characters.</p>\r";
			}

			if ($validContactFirstName == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Contact First Name</em> between 2 and 15 characters.</p>\r";
			}

			if ($validPhone == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Phone Number</em> in the format (XXX) XXX-XXXX</p>\r";
			}

			if ($validAddressLine1 == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter an <em>Address Line 1</em> between 2 and 50 characters.</p>\r";
			}

			if ($validAddressLine2 == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter an <em>Address Line 2</em> between 2 and 50 characters.</p>\r";
			}

			if ($validCity == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>City</em> between 2 and 20 characters.</p>\r";
			}

			if ($validState == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a two character <em>State</em> code.</p>\r";
			}

			if ($validPostalCode == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a five digit <em>Postal Code</em>.</p>\r";
			}

			if ($validCountry == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Country</em> between 2 and 50 characters.</p>\r";
			}

			if ($validSalesRepEmployeeNumber == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a four digit <em>Sales Rep Employee Number</em>.</p>\r";
			}

			if ($validCreditLimit == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Credit Limit</em> between 2 and 6 digits.</p>\r";
			}

			if ($validUsername == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Username</em> consisting of only letters, numbers, and the special characters '_', '-', and '@'. Username must be between 8 and 50 characters long and cannot start with a special character.</p>\r";
			}

			if ($validPassword == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a <em>Password</em> consisting of only letters, numbers, and the special characters '_', '-', and '@'. Password must be between 8 and 50 characters long and cannot start with a special character.</p>\r";
			}

			if ($validEmail == false) {
				$error_text .= "\t\t\t\t\t<p>Please enter a valid <em>Email</em> address.</p>\r";
			}

			// Display Form
			$output_form = true;
		} else { // All input is valid

			// Check for Existing Username
			$queryUsername = "SELECT * from customers where username ='$validUsername'";
			$resultUsername = mysqli_query($dbc, $queryUsername);

			// If username is not unique, display error text
			if (mysqli_num_rows($resultUsername) > 0) {

				if (mysqli_num_rows($resultUsername) > 0) {
					$error_text .= "\t\t\t\t\t<p>Username must be unique.</p>\r";
				}

				// Display Form
				$output_form = true;
			} else { // Username is unique

				// If the Sales Rep is not assigned
				if ($validSalesRepEmployeeNumber == ' ') {
					// Insert Query
					$sql = "INSERT INTO customers (customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit, username, password, email) 
							VALUES ('$validCustomerName', '$validContactLastName', '$validContactFirstName', '$validPhone', '$validAddressLine1', '$validAddressLine2', '$validCity', '$validState', '$validPostalCode', '$validCountry', NULL, '$validCreditLimit', '$username', '$md5hashpwd', '$email')";
				} else { // Else if the sales rep is assigned

					// Insert Query
					$sql = "INSERT INTO customers (customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit, username, password, email) 
							VALUES ('$validCustomerName', '$validContactLastName', '$validContactFirstName', '$validPhone', '$validAddressLine1', '$validAddressLine2', '$validCity', '$validState', '$validPostalCode', '$validCountry', '$validSalesRepEmployeeNumber', '$validCreditLimit', '$username', '$md5hashpwd', '$email')";
				} // End if/else Sales Rep Assigned

				// Insert Form Data Into Database
				if (mysqli_query($dbc, $sql)) {
					echo "Records inserted successfully.";
				} else {
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($dbc);
				}

				// Do not display form
				$output_form = false;

			} // End if/else existing username
		} // End if/else field validation

	} // End if/else empty field check */
} // End isset($_POST['submit'])

// Options for Employee Code Select Box
$query = "SELECT `employeeNumber` FROM `employees` ORDER BY `employeeNumber`";

// Add Null Value to Dropdown
$withNull = true;

// Get Employee Number Options
$employeeNumberOptions = getDropdownList($dbc, $query, 'employeeNumber', $withNull);

// Switch to HTML to Display Output
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
					<li class="selected"><a href="addcustomer.php">Add Customer</a></li>
					<li><a href="creditlimits.php">Credit Limit Report</a></li>
					<li><a href="inventory.php">Product Inventory Report</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">

				<!-- Form Output -->
				<?php if ($output_form) { ?>

					<h2>New Customer Entry Form</h2>

					<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

						<?= $error_text ?>

						<br>

						<table>

							<tr>
								<td>Customer Name: </td>
								<td><input name="customerName" type="text" value="<?= $customerName ?>"></td>
							</tr>

							<tr>
								<td>Contact Last Name: </td>
								<td><input name="contactLastName" type="text" value="<?= $contactLastName ?>"></td>
							</tr>

							<tr>
								<td>Contact First Name: </td>
								<td><input name="contactFirstName" type="text" value="<?= $contactFirstName ?>"></td>
							</tr>

							<tr>
								<td>Phone Number: </td>
								<td><input name="phone" type="text" value="<?= $phone ?>" placeholder="(xxx) xxx-xxxx"></td>
							</tr>

							<tr>
								<td>Address Line 1: </td>
								<td><input name="addressLine1" type="text" value="<?= $addressLine1 ?>"></td>
							</tr>

							<tr>
								<td>Address Line 2: </td>
								<td><input name="addressLine2" type="text" value="<?= $addressLine2 ?>"></td>
							</tr>

							<tr>
								<td>City: </td>
								<td><input name="city" type="text" value="<?= $city ?>"></td>
							</tr>

							<tr>
								<td>State: </td>
								<td><input name="state" type="text" value="<?= $state ?>"></td>
							</tr>

							<tr>
								<td>Postal Code: </td>
								<td><input name="postalCode" type="text" value="<?= $postalCode ?>"></td>
							</tr>

							<tr>
								<td>Country: </td>
								<td><input name="country" type="text" value="<?= $country ?>"></td>
							</tr>

							<tr>
								<td>Sales Rep Employee Number: </td>
								<td>
									<?= $employeeNumberOptions ?>
								</td>
							</tr>

							<tr>
								<td>Credit Limit: </td>
								<td><input name="creditLimit" type="text" value="<?= $creditLimit ?>"></td>
							</tr>

							<tr>
								<td>Username: </td>
								<td><input name="username" type="text" value="<?= $username ?>"></td>
							</tr>

							<tr>
								<td>Password: </td>
								<td><input name="password" type="password" value="<?= $password ?>"></td>
							</tr>

							<tr>
								<td>Email Address: </td>
								<td><input name="email" type="text" value="<?= $email ?>"></td>
							</tr>

						</table>

						<input name="submit" id="submit" type="submit">
					</form>

				<?php } else { // No Form Output ?>

					<h2>Customer Record Added</h2>

					<table>

						<tr>
							<td>Customer Name: </td>
							<td><?= $validCustomerName ?></td>
						</tr>

						<tr>
							<td>Contact Last Name: </td>
							<td><?= $validContactLastName ?></td>
						</tr>

						<tr>
							<td>Contact First Name: </td>
							<td><?= $validContactFirstName ?></td>
						</tr>

						<tr>
							<td>Phone Number: </td>
							<td><?= $validPhone ?></td>
						</tr>

						<tr>
							<td>Address Line 1: </td>
							<td><?= $validAddressLine1 ?></td>
						</tr>

						<tr>
							<td>Address Line 2: </td>
							<td><?= $validAddressLine2 ?></td>
						</tr>

						<tr>
							<td>City: </td>
							<td><?= $validCity ?></td>
						</tr>

						<tr>
							<td>State: </td>
							<td><?= $validState ?></td>
						</tr>

						<tr>
							<td>Postal Code: </td>
							<td><?= $validPostalCode ?></td>
						</tr>

						<tr>
							<td>Country: </td>
							<td><?= $validCountry ?></td>
						</tr>

						<tr>
							<td>Sales Rep Employee Number: </td>
							<td><?= $validSalesRepEmployeeNumber ?></td>
						</tr>

						<tr>
							<td>Credit Limit: </td>
							<td><?= $validCreditLimit ?></td>
						</tr>

						<tr>
							<td>Email Address: </td>
							<td><?= $validEmail ?></td>
						</tr>

					</table>

					<!-- End if/else Form Output -->
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
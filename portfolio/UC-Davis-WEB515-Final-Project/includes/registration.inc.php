<?php

ob_start();

// Includes
require_once __DIR__ . "/variables.inc.php";


/* Field Validation Function
-------------------------------------------------------------------*/
function fieldValidation($regex, $my_string)
{
	if (preg_match($regex, $my_string)) {
		return $my_string;
	} else {
		return false;
	}
}

/* Registration function
-------------------------------------------------------------------*/
function userRegistration($dbc, &$registration_error_text, &$registration_form)
{

	ob_start();

	if (isset($_POST['register'])) { // data posted

		$debug = false;

		// If debug flag is set to true
		if ($debug) {

			// Display text input
			echo '<pre style="z-index: 3000>; position: absolute; top: 200px;">';
			print_r($_POST);
			echo "</pre>";

			// die("temp stop point");
		} // End debug only

		// Get Form Input
		$registrationFirstName = trim(mysqli_real_escape_string($dbc, $_POST['registrationFirstName']));
		$registrationLastName = trim(mysqli_real_escape_string($dbc, $_POST['registrationLastName']));
		$registrationEmailAddress = trim(mysqli_real_escape_string($dbc, $_POST['registrationEmailAddress']));
		$registrationUsername = trim(mysqli_real_escape_string($dbc, $_POST['registrationUsername']));
		$registrationPassword = trim(mysqli_real_escape_string($dbc, $_POST['registrationPassword']));

		// Registration RegEx Patterns
		$regExFirstName = '/^[a-zA-Z]{2,25}$/';
		$regExLastName = '/^[a-zA-Z]{2,25}$/';
		$regExEmailAddress = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-za-z]{2,}$/';
		$regExUsername = '/^[a-zA-Z0-9!@#$&*]{8,25}$/';
		$regExPassword = '/^[a-zA-Z0-9!@#$&*]{8,25}$/';


		// Validate Input
		$validFirstName = fieldValidation($regExFirstName, $registrationFirstName);
		$validLastName = fieldValidation($regExLastName, $registrationLastName);
		$validEmailAddress = fieldValidation($regExEmailAddress, $registrationEmailAddress);
		$validUsername = fieldValidation($regExUsername, $registrationUsername);
		$validPassword = fieldValidation($regExPassword, $registrationPassword);

		// Check for Empty Fields
		if (
			empty($_POST['registrationFirstName']) ||
			empty($_POST['registrationLastName']) ||
			empty($_POST['registrationEmailAddress']) ||
			empty($_POST['registrationUsername']) ||
			empty($_POST['registrationPassword'])
		) {

			// Error Text
			$registration_error_text .= "\t\t\t\t\t<p>All fields are mandatory.</p>\r";

			// Display Form
			$registration_form = true;

		} else {
			if (
				$validFirstName == false ||
				$validLastName == false ||
				$validEmailAddress == false ||
				$validUsername == false ||
				$validPassword == false
			) {

				// First Name Error
				if ($validFirstName == false) {
					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Please enter a first name between 2 and 25 characters in the field provided.</p>\r";
				}

				// Last Name Error
				if ($validLastName == false) {
					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Please enter a last name between 2 and 25 characters in the field provided.</p>\r";
				}

				// Email Address Error
				if ($validEmailAddress == false) {
					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Please enter a valid email address in the field provided.</p>\r";
				}

				// Username Error
				if ($validUsername == false) {
					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Please enter a valid username in the field provided.<br>Valid usernames must be at least 8 characters long and can contain letters, numbers, and the special characters [!@#$&*].</p>\r";
				}

				// Password Error
				if ($validPassword == false) {
					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Please enter a valid password in the field provided.<br>Valid passwords must be at least 8 characters long and can contain letters, numbers, and the special characters [!@#$&*].</p>\r";
				}

				// Display Form
				$registration_form = true;

			} else {

				// Check if username exists
				$sql_u = "SELECT * FROM users WHERE userUsername='$validUsername'";
				$res_u = mysqli_query($dbc, $sql_u);

				// Check if email exists
				$sql_e = "SELECT * FROM users WHERE userEmailAddress='$validEmailAddress'";
				$res_e = mysqli_query($dbc, $sql_e);

				if (mysqli_num_rows($res_u) > 0) {

					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Username already registered.</p>\r";

					// Display Form
					$registration_form = true;

				} else if (mysqli_num_rows($res_e) > 0) {

					// Error Text
					$registration_error_text .= "\t\t\t\t\t<p>Email address already registered.</p>\r";

					// Display Form
					$registration_form = true;

				} else {

					// Create MD5 Password Hash
					$validMd5HashPwd = md5($validPassword);

					// Insert Query
					$sql = "INSERT INTO users (userFirstName, userLastName, userEmailAddress, userUsername, userHashedPassword) 
                        VALUES ('$validFirstName', '$validLastName', '$validEmailAddress', '$validUsername', '$validMd5HashPwd')";

					// Insert Form Data Into Database
					if (mysqli_query($dbc, $sql)) {
						echo "Records inserted successfully.";
					} else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($dbc);
					}

					// Do not display form
					$registration_form = false;

				} // End if/else username in use

			} // End if/else field validation

		}
	}
}

ob_end_flush();
?>
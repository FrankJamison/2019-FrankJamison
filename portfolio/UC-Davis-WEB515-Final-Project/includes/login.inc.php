<?php

/* Login function
-------------------------------------------------------------------*/
function userLogin($dbc, &$error_text, $ROOT)
{

    // Debug Flag
    $debug = false;

    // Error Reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    // Login Form display variable
    $login_form = true;

    // Database Login Data Query
    $query = "SELECT userID, userUsername, userHashedPassword, userFirstName, userLastName FROM users";

    // Database Login Query Result
    $result = mysqli_query($dbc, $query)
        or die("Error querying database");

    $storedMemberID = '';
    $storedMemberUsername = '';
    $storedMemberPassword = '';
    $storedMemberFirstName = '';
    $storedMemberLastName = '';

    // Login Form Input Variables
    $loginUsername = '';
    $loginPassword = '';
    $loginMd5HashPwd = '';

    $error_text = '';

    // If data is posted
    if (isset($_POST["login"])) {

        // Start debug only
        if ($debug) {

            // Display text input
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            // die("temp stop point");
        } // End debug only

        // Get Form Input
        $loginUsername = trim(mysqli_real_escape_string($dbc, $_POST["loginUsername"]));
        $loginPassword = trim(mysqli_real_escape_string($dbc, $_POST["loginPassword"]));
        $loginMd5HashPwd = md5($loginPassword);

        // Get stored data
        while ($row = mysqli_fetch_array($result)) {

            // Check username against result
            if ($loginUsername == $row["userUsername"]) {

                // Store user data
                $storedMemberID = $row["userID"];
                $storedMemberUsername = $row["userUsername"];
                $storedMemberPassword = $row["userHashedPassword"];
                $storedMemberFirstName = $row["userFirstName"];
                $storedMemberLastName = $row["userLastName"];

                // Break after storing data 
                break;

            } // End check username against result

        } // End get stored data

        // Check for authenticated user
        if ($loginUsername == $storedMemberUsername && $loginMd5HashPwd == $storedMemberPassword) {

            // Start Session
            session_start();

            // Create Session Variables
            $_SESSION["memberID"] = $storedMemberID;
            $_SESSION["memberUsername"] = $storedMemberUsername;
            $_SESSION["memberPassword"] = $storedMemberPassword;
            $_SESSION["memberFirstName"] = $storedMemberFirstName;
            $_SESSION["memberLastName"] = $storedMemberLastName;

            // Redirect to Members Area
            header("Location: $ROOT/members/index.php");

        } // End check for authenticated user

        // Check for Empty Fields
        if (empty($_POST["loginUsername"]) || empty($_POST["loginPassword"])) {

            // Error Text
            $error_text .= '<p class="error">Both fields are required.</p>';

            // Display Form
            $login_form = true;

        } else {

            // Error Text
            $error_text .= '<p class="error">Member not found.</p>';

            // Do not display form
            $login_form = true;

        } // End if/else check for empty fields

    } // End if data is posted
}

?>
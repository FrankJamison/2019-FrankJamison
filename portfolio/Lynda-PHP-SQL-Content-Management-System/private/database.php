<?php

require_once('db_credentials.php');

// Connect to database
function db_connect()
{
    // Make database connection
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    // Confirm database connection
    confirm_db_connect();

    // return database connection
    return $connection;
}

// Confirm database connection
function confirm_db_connect()
{
    // Display error message on error
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

// Confirm result set
function confirm_result_set($result_set)
{
    if (!$result_set) {
        exit("Database query failed.");
    }
}

// Disconnect from database
function db_disconnect($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

// Escape String
function db_escape($connection, $string)
{
    return mysqli_real_escape_string($connection, $string);
}

?>
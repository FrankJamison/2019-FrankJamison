<?php

// Find all subjects
function find_all_subjects($options = [])
{

    // Get database connection
    global $db;

    // Check for visibility
    $visible = $options['visible'] ?? false;

    // Get subjects ordered by position
    $sql = "SELECT * FROM subjects ";
    if ($visible) {
        $sql .= "WHERE visible = true ";
    }
    $sql .= "ORDER BY position ASC";

    // Query the database
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Return the data set
    return $result;
}

// Count all subjects
function count_all_subjects()
{

    // Get database connection
    global $db;

    // Get subjects ordered by position
    $sql = "SELECT COUNT(id) FROM subjects ";

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Get rows
    $row = mysqli_fetch_row($result);

    // Free result
    mysqli_free_result($result);

    // Get row count
    $count = $row[0];

    // Return count
    return $count;
}

// Find subject by ID
function find_subject_by_id($id, $options = [])
{

    // Get database connection
    global $db;

    // Check for visibility
    $visible = $options['visible'] ?? false;

    // Create sql query
    $sql = "SELECT * FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true";
    }

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Get subject
    $subject = mysqli_fetch_assoc($result);

    // Free result set memory
    mysqli_free_result($result);

    // Return subject
    return $subject;
}

// Validate Subject
function validate_subject($subject)
{

    $errors = [];

    // menu_name
    if (is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } else if (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int) $subject['position'];

    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }

    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $subject['visible'];

    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    return $errors;
}


// Insert Subject
function insert_subject($subject)
{

    // Get database connection
    global $db;

    // Validate subject data
    $errors = validate_subject($subject);

    if (!empty($errors)) {
        return $errors;
    }

    // Shift subject positions
    shift_subject_positions(0, $subject['position']);

    // Create sql query
    $sql = "INSERT INTO subjects ";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $subject['menu_name']) . "', ";
    $sql .= "'" . db_escape($db, $subject['position']) . "', ";
    $sql .= "'" . db_escape($db, $subject['visible']) . "'";
    $sql .= ")";

    // Submit query
    $result = mysqli_query($db, $sql);

    // Check for success
    if ($result) {

        // Return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;
    }

}

// Update Subject
function update_subject($subject)
{

    // Get database connection
    global $db;

    // Validate subject data
    $errors = validate_subject($subject);

    if (!empty($errors)) {
        return $errors;
    }

    // Find old subject position
    $old_subject = find_subject_by_id($subject['id']);
    $old_position = $old_subject['position'];

    // Shift subject positions
    shift_subject_positions($old_position, $subject['position'], $subject['id']);

    // Create sql query
    $sql = "UPDATE subjects SET ";
    $sql .= "menu_name='" . db_escape($db, $subject['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $subject['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $subject['visible']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
    $sql .= "LIMIT 1";

    // Query database
    $result = mysqli_query($db, $sql);

    // Check for update success
    if ($result) {

        // return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;

    }

}

// Delete subject
function delete_subject($id)
{

    // Get database connection
    global $db;

    // Find old subject position
    $old_subject = find_subject_by_id($id);
    $old_position = $old_subject['position'];

    // Shift subject positions
    shift_subject_positions($old_position, 0, $id);

    // Create sql query
    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";

    // Run query
    $result = mysqli_query($db, $sql);

    // Check for success
    if ($result) {

        // return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;
    }

}

// Find all pages
function find_all_pages()
{

    // Get database connection
    global $db;

    // Get pages ordered by position
    $sql = "SELECT * FROM pages ";
    $sql .= "ORDER BY subject_id ASC, position ASC";

    // Query database
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Return the data set
    return $result;
}

// Find page by ID
function find_page_by_id($id, $options = [])
{

    // Get database connection
    global $db;

    // Check for visibility
    $visible = $options['visible'] ?? false;

    // Create sql query
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true";
    }

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Get subject
    $page = mysqli_fetch_assoc($result);

    // Free result set memory
    mysqli_free_result($result);

    // Return subject
    return $page;
}

// Validate Page
function validate_page($page)
{

    $current_id = $page['id'] ?? '0';

    // menu_name
    if (is_blank($page['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } else if (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    } else if (!has_unique_page_menu_name($page['menu_name'], $current_id)) {
        $errors[] = "Menu name must be unique.";
    }

    // subject_id
    // Make sure we are working with an integer
    $subject_id_int = (int) $page['subject_id'];

    if ($subject_id_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }

    if ($subject_id_int > 9999999999) {
        $errors[] = "Position must be less than 9,999,999,999.";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int) $page['position'];

    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }

    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $page['visible'];

    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    return $errors;
}

// Insert Page
function insert_page($page)
{

    // Get database connection
    global $db;

    // Validate subject data
    $errors = validate_page($page);

    if (!empty($errors)) {
        return $errors;
    }

    // Shift page positions
    shift_page_positions(0, $page['position'], $page['subject_id']);

    // Create sql query
    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $page['subject_id']) . "', ";
    $sql .= "'" . db_escape($db, $page['menu_name']) . "', ";
    $sql .= "'" . db_escape($db, $page['position']) . "', ";
    $sql .= "'" . db_escape($db, $page['visible']) . "', ";
    $sql .= "'" . db_escape($db, $page['content']) . "' ";
    $sql .= ")";

    // Submit query
    $result = mysqli_query($db, $sql);

    // Check for success
    if ($result) {

        // Return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;
    }

}

// Update Page
function update_page($page)
{

    // Get database connection
    global $db;

    // Validate subject data
    $errors = validate_page($page);

    if (!empty($errors)) {
        return $errors;
    }

    // Find old page position
    $old_page = find_page_by_id($page['id']);
    $old_position = $old_page['position'];

    // Shift page positions
    shift_page_positions($old_position, $page['position'], $page['subject_id'], $page['id']);

    // Create sql query
    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
    $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $page['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
    $sql .= "content='" . db_escape($db, $page['content']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
    $sql .= "LIMIT 1";

    // Query database
    $result = mysqli_query($db, $sql);

    // Check for update success
    if ($result) {

        // return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;

    }

}

// Validate Page Record
function validate_page_record($id)
{

    // Check for existing record
    if (!has_existing_page_record($id)) {
        $errors[] = "Record does not exist.";
    }

    return $errors;
}

// Delete Page
function delete_page($id)
{

    // Get database connection
    global $db;

    $errors = validate_page_record($id);

    if (!empty($errors)) {
        return $errors;
    }

    // Find old page position
    $old_page = find_page_by_id($id);
    $old_position = $old_page['position'];

    // Shift page positions
    shift_page_positions($old_position, 0, $old_page['subject_id'], $id);

    // Create sql query
    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . $id . "' ";
    $sql .= "LIMIT 1";

    // Run query
    $result = mysqli_query($db, $sql);

    // Check for success
    if ($result) {

        // return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;
    }

}

// Find pages by subject ID
function find_pages_by_subject_id($subject_id, $options = [])
{

    // Get database connection
    global $db;

    // Check for visibility
    $visible = $options['visible'] ?? false;

    // Create sql query
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY position ASC";

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Return result set
    return $result;
}

// Count pages by subject ID
function count_pages_by_subject_id($subject_id, $options = [])
{

    // Get database connection
    global $db;

    // Check for visibility
    $visible = $options['visible'] ?? false;

    // Create sql query
    $sql = "SELECT COUNT(id) FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY position ASC";

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Get rows
    $row = mysqli_fetch_row($result);

    // Free result
    mysqli_free_result($result);

    // Get row count
    $count = $row[0];

    // Return count
    return $count;
}

// Find all admins
function find_all_admins()
{

    // Get database connection
    global $db;

    // Get subjects ordered by position
    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";

    // Query the database
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Return the data set
    return $result;
}

// Find admin by ID
function find_admin_by_id($id)
{

    // Get database connection
    global $db;

    // Create sql query
    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Get subject
    $admin = mysqli_fetch_assoc($result);

    // Free result set memory
    mysqli_free_result($result);

    // Return subject
    return $admin;
}

// Find admin by ID
function find_admin_by_username($username)
{

    // Get database connection
    global $db;

    // Create sql query
    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";

    // Get result set
    $result = mysqli_query($db, $sql);

    // Confirm result set
    confirm_result_set($result);

    // Get subject
    $admin = mysqli_fetch_assoc($result);

    // Free result set memory
    mysqli_free_result($result);

    // Return subject
    return $admin;
}

// Validate admin
function validate_admin($admin, $options = [])
{

    $password_required = $options['password_required'] ?? true;

    $current_id = $admin['id'] ?? '0';

    // first_name
    if (is_blank($admin['first_name'])) {
        $errors[] = "First name cannot be blank.";
    } else if (!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // last_name
    if (is_blank($admin['last_name'])) {
        $errors[] = "Last name cannot be blank.";
    } else if (!has_length($admin['last_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // email
    if (is_blank($admin['email'])) {
        $errors[] = "Email cannot be blank.";
    } else if (!has_length($admin['email'], ['max' => 255])) {
        $errors[] = "Email must not have more than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
        $errors[] = "Email address must be properly formatted.";
    }

    // username
    if (is_blank($admin['username'])) {
        $errors[] = "Username cannot be blank.";
    } else if (!has_length($admin['username'], ['min' => 8, 'max' => 255])) {
        $errors[] = "Username must be between 8 and 255 characters.";
    } else if (!has_unique_admin_username($admin['username'], $current_id)) {
        $errors[] = "Username must be unique.";
    }

    if ($password_required) {
        // password
        if (is_blank($admin['password'])) {
            $errors[] = "Password cannot be blank.";
        } else if (!has_length($admin['password'], ['min' => 12, 'max' => 255])) {
            $errors[] = "Password must be between 12 and 255 characters.";
        } else {
            if (!preg_match('/[A-Z]/', $admin['password'])) {
                $errors[] = "Password must contain an uppercase letter.";
            }
            if (!preg_match('/[a-z]/', $admin['password'])) {
                $errors[] = "Password must contain a lowercase letter.";
            }
            if (!preg_match('/[0-9]/', $admin['password'])) {
                $errors[] = "Password must contain a number.";
            }
            if (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
                $errors[] = "Password must contain a special character.";
            }
        }

        // confirm_password
        if (is_blank($admin['confirm_password'])) {
            $errors[] = "The confirm password cannot be blank.";
        } else if (!has_password_match($admin['password'], $admin['confirm_password'])) {
            $errors[] = "The confirm password must match the password";
        }
    }

    return $errors;
}

// Insert admin
function insert_admin($admin)
{

    // Get database connection
    global $db;

    // Validate subject data
    $errors = validate_admin($admin);

    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    // Create sql query
    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "'" . db_escape($db, $admin['email']) . "', ";
    $sql .= "'" . db_escape($db, $admin['username']) . "', ";
    $sql .= "'" . db_escape($db, $hashed_password) . "' ";
    $sql .= ")";

    // Submit query
    $result = mysqli_query($db, $sql);

    // Check for success
    if ($result) {

        // Return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;
    }

}

// Update admin
function update_admin($admin)
{

    // Get database connection
    global $db;

    // Check to see if password is sent
    $password_sent = !is_blank($admin['password']);

    // Validate admin data
    $errors = validate_admin($admin, ['password_required' => $password_sent]);

    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    // Create sql query
    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    if ($password_sent) {
        $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";

    // Query database
    $result = mysqli_query($db, $sql);

    // Check for update success
    if ($result) {

        // return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;

    }

}

// Validate admin record
function validate_admin_record($id)
{

    // Check for existing record
    if (!has_existing_admin_record($id)) {
        $errors[] = "Record does not exist.";
    }

    return $errors;
}

// Delete admin
function delete_admin($id)
{

    // Get database connection
    global $db;

    $errors = validate_admin_record($id);

    if (!empty($errors)) {
        return $errors;
    }


    // Create sql query
    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . $id . "' ";
    $sql .= "LIMIT 1";

    // Run query
    $result = mysqli_query($db, $sql);

    // Check for success
    if ($result) {

        // return true
        return true;

    } else {

        // Display error
        echo mysqli_error($db);

        // Disconnect from database
        db_disconnect($db);

        // Exit Script
        exit;
    }

}

// Shift Subject Positions
function shift_subject_positions($start_pos, $end_pos, $current_id = 0)
{

    // Get database connection
    global $db;

    // Exit function if start position and end position are the same
    if ($start_pos == $end_pos) {
        return;
    }

    $sql = "UPDATE subjects ";

    if ($start_pos == 0) {
        // New item. +1 to items greater than end position
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif ($end_pos == 0) {
        // Delete item. -1 from items > start position
        $sql .= "SET position = position -1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif ($start_pos < $end_pos) {
        // Move later. -1 from items between (including end position)
        $sql .= "SET position = position - 1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif ($start_pos > $end_pos) {
        // Move earlier. +1 to items between (including end position)
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }

    // Exclude the current id in the SQL WHERE clause
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";

    $result = mysqli_query($db, $sql);

    if ($result) {
        // Successful update
        return true;
    } else {
        // Failed update
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Shift Page Positions
function shift_page_positions($start_pos, $end_pos, $subject_id, $current_id = 0)
{

    // Get database connection
    global $db;

    // Exit function if start position and end position are the same
    if ($start_pos == $end_pos) {
        return;
    }

    $sql = "UPDATE pages ";

    if ($start_pos == 0) {
        // New item. +1 to items greater than end position
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif ($end_pos == 0) {
        // Delete item. -1 from items > start position
        $sql .= "SET position = position -1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif ($start_pos < $end_pos) {
        // Move later. -1 from items between (including end position)
        $sql .= "SET position = position - 1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif ($start_pos > $end_pos) {
        // Move earlier. +1 to items between (including end position)
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }

    // Exclude the current id in the SQL WHERE clause
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
    $sql .= "AND subject_id = '" . db_escape($db, $subject_id) . "'";

    $result = mysqli_query($db, $sql);

    if ($result) {
        // Successful update
        return true;
    } else {
        // Failed update
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}
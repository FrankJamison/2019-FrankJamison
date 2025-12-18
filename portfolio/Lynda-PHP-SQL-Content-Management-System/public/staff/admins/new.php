<?php

require_once('../../../private/initialize.php');

require_login();

if (is_post_request()) {

    // Create admin associative array from POST values
    $admin = [];
    $admin['first_name'] = $_POST['first_name'];
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';
    $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

    // Insert subject
    $result = insert_admin($admin);

    // Check for errors
    if ($result === true) {

        // Get new record id
        $new_id = mysqli_insert_id($db);

        // Set status message
        $_SESSION['message'] = "The admin was created successfully";

        // Go to subject detail page
        redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));

    } else {

        // Get errors
        $errors = $result;
    }

} else {

}

?>

<?php $page_title = 'Create Admin'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="admins new">
        <h1>Create Admin</h1>

        <!-- Display Errors -->
        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/admins/new.php') ?>" method="post">
            <dl>
                <dt>First Name</dt>
                <dd><input type="text" name="first_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Last Name</dt>
                <dd><input type="text" name="last_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Email</dt>
                <dd><input type="text" name="email" value="" /></dd>
            </dl>
            <dl>
                <dt>Username</dt>
                <dd><input type="text" name="username" value="" /></dd>
            </dl>
            <dl>
                <dt>Password</dt>
                <dd><input type="password" name="password" value="" /></dd>
            </dl>
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type="password" name="confirm_password" value="" /></dd>
            </dl>
            <p>
                Passwords should be at least 12 characters and include at least one uppercase letter, one lowercase
                letter, one number, and one special character.
            </p>
            <div id="operations">
                <input type="submit" value="Create Admin" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
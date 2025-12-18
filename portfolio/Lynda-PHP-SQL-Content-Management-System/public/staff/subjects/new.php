<?php

require_once('../../../private/initialize.php');

require_login();

$num_subjects = $_GET['num_subjects'] ?? '0';

if (is_post_request()) {

    // Create subject associative array from POST values
    $subject = [];
    // $subject['id'] = $id;
    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';

    // Insert subject
    $result = insert_subject($subject);

    // Check for errors
    if ($result === true) {

        // Set status message
        $_SESSION['message'] = "The subject was created successfully";

        // Go to subject detail page
        redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));

    } else {

        // Get errors
        $errors = $result;
    }

    // Get new record id
    //$new_id = mysqli_insert_id($db);

    // Go to subject detail page
    //redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));

} else {
    // redirect_to(url_for('/staff/subjects/new.php'));
}

// Get subject set
$subject_set = find_all_subjects();

// Get subject count
$subject_count = mysqli_num_rows($subject_set) + 1;

// Free subject set memory
mysqli_free_result($subject_set);

// Create subject associative array
$subject = [];
$subject['position'] = $subject_count;


?>

<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject new">
        <h1>Create Subject</h1>

        <!-- Display Errors -->
        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/subjects/new.php?num_subjects=' . h(u($subject_count + 1))) ?>"
            method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php
                        for ($i = 1; $i <= $subject_count; $i++) {
                            echo "<option value=\"{$i}\"";
                            if ($subject["position"] == $i) {
                                echo " selected";
                            }
                            echo ">{$i}</option>";
                        }
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0" />
                    <input type="checkbox" name="visible" value="1" />
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Subject" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
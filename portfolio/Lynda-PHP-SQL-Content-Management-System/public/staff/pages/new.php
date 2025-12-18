<?php

require_once('../../../private/initialize.php');

require_login();

if (!isset($_GET['subject_id'])) {
    redirect_to(url_for('/staff/subjects/index.php'));
}

// Get subject id
$subject_id = $_GET['subject_id'];

// Find subject
$subject = find_subject_by_id($subject_id);


if (is_post_request()) {

    // Create subject associative array from POST values
    $page = [];
    $page['subject_id'] = $_POST['subject_id'];
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    // Insert subject
    $result = insert_page($page);

    // Check for errors
    if ($result === true) {

        // Get new record id
        $new_id = mysqli_insert_id($db);

        // Set status message
        $_SESSION['message'] = "The page was created successfully";

        // Go to subject detail page
        redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));

    } else {

        // Get errors
        $errors = $result;
    }

} else {
    $page = [];
    $page['subject_id'] = $_GET['subject_id'] ?? '1';
    $page['menu_name'] = '';
    $page['position'] = '';
    $page['visible'] = '';
    $page['content'] = '';
}

// Get Subject Set
$subject_set = find_all_subjects();

?>

<?php $page_title = 'Create Page'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject_id))); ?>">&laquo; Back
        to Subject Page</a>

    <div class="pages new">
        <h1>Create Page</h1>

        <!-- Display Errors -->
        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/pages/new.php?subject_id=' . h(u($subject_id))); ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Subject</dt>
                <dd>
                    <input type="text" name="subject_id" value="<?php echo h($subject['menu_name']); ?>" />
                </dd>
            </dl>

            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php
                        $next_position = count_pages_by_subject_id($subject_id) + 1;
                        for ($i = 1; $i <= $next_position; $i++) {
                            echo "<option value=\"{$i}\"";
                            if ($next_position == $i) {
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
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea cols="50" rows="4" name="content"></textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Page" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
<?php

// Free subject set memory
mysqli_free_result($subject_set);
?>
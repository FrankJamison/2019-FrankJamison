<?php

require_once('../../../private/initialize.php');

require_login();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
}

$id = $_GET['id'];

if (is_post_request()) {

    // Create subject associative array from POST values
    $page = [];
    $page['id'] = $id;
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    // Update subject
    $result = update_page($page);

    // Check update for errors
    if ($result === true) {

        // Set status message
        $_SESSION['message'] = "The page was updated successfully";

        // Show record
        redirect_to(url_for('/staff/pages/show.php?id=' . $id));

    } else {

        // Get errors
        $errors = $result;

    }

} else {

    // Find page by id
    $page = find_page_by_id($id);

}

// Get Subject Set
$subject_set = find_all_subjects();

?>

<?php $page_title = 'Edit Page'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

    <a class="back-link"
        href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))); ?>">&laquo; Back to
        Subject Page</a>

    <div class="pages edit">
        <h1>Edit Page</h1>

        <!-- Display Errors -->
        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($id))); ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>" /></dd>
            </dl>
            <dl>
                <dt>Subject</dt>
                <dd>
                    <input type="text" name="subject_id" value="<?php echo h($page['subject_id']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php
                        $page_count = count_pages_by_subject_id($page['subject_id']);
                        for ($i = 1; $i <= $page_count; $i++) {
                            echo "<option value=\"{$i}\"";
                            if ($page["position"] == $i) {
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
                    <input type="checkbox" name="visible" value="1" <?php if ($page['visible'] == '1') {
                        echo " checked";
                    }
                    ; ?> />
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea cols="50" rows="4" name="content"><?php echo $page['content']; ?></textarea>
                </dd>
            </dl>

            <div id="operations">
                <input type="submit" value="Edit Page" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
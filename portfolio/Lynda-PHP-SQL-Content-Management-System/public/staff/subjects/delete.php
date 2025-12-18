<?php

require_once('../../../private/initialize.php');

require_login();

// Redirect to index.php if no id
if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/subjects/index.php'));
}

// Set id from GET variable
$id = $_GET['id'];

if (is_post_request()) {

  // Get subject by id
  $subject = find_subject_by_id($id);

  // Delete subject
  $result = delete_subject($id);

  // Set status message
  $_SESSION['message'] = "The subject was deleted successfully";

  // Redirect ti subject index page
  redirect_to(url_for('/staff/subjects/index.php'));
} else {

  // Find the desired subject
  $subject = find_subject_by_id($id);

}

?>

<?php $page_title = 'Delete Subject'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this subject?</p>
    <p class="item"><?php echo h($subject['menu_name']); ?></p>

    <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
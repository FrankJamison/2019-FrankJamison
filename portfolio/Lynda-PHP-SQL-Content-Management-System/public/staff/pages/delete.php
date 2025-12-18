<?php

require_once('../../../private/initialize.php');

require_login();

// Redirect to index.php if no id
if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/pages/index.php'));
}

// Set id from GET variable
$id = $_GET['id'];

// Find the desired subject
$page = find_page_by_id($id);

if (is_post_request()) {

  // Delete subject
  $result = delete_page($id);

  // Check update for errors
  if ($result === true) {

    // Set status message
    $_SESSION['message'] = "The page was deleted successfully";

    // Redirect to pages index page
    redirect_to(url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))));

  }

} else {

}

?>

<?php $page_title = 'Delete Page'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))); ?>">&laquo;
    Back to Subject Page</a>

  <div class="page delete">
    <h1>Delete Page</h1>
    <p>Are you sure you want to delete this page?</p>
    <p class="item"><?php echo h($page['menu_name']); ?></p>

    <!-- Display Errors -->
    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Page" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
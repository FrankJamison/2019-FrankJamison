<?php

require_once('../../../private/initialize.php');

require_login();

// Redirect to index.php if no id
if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/admins/index.php'));
}

// Set id from GET variable
$id = $_GET['id'];

if (is_post_request()) {

  // Delete subject
  $result = delete_admin($id);

  // Check update for errors
  if ($result === true) {

    // Set status message
    $_SESSION['message'] = "The admin was deleted successfully";

    // Redirect to pages index page
    redirect_to(url_for('/staff/admins/index.php'));

  } else {

    // Get errors
    $errors = $result;

  }

} else {

  // Find the desired subject
  $admin = find_admin_by_id($id);

}

?>

<?php $page_title = 'Delete Admin'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin delete">
    <h1>Delete Admin</h1>
    <p>Are you sure you want to delete this admin?</p>
    <p class="item"><?php echo h($admin['username']); ?></p>

    <!-- Display Errors -->
    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Admin" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
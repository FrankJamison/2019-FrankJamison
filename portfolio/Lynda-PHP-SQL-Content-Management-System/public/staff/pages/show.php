<?php require_once('../../../private/initialize.php'); ?>

<?php require_login(); ?>

<?php

// If no parameter, set to 1
$id = $_GET['id'] ?? '1';

// Get page
$page = find_page_by_id($id);

// Get subject
$subject = find_subject_by_id($page['subject_id']);

?>

<?php $pageTitle = "Show Page"; ?>

<?php require(SHARED_PATH . "/staff-header.php"); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">&laquo;
        Back to Subject Page</a>

    <div class="page show">
        <h1>Page: <?php echo h($page['menu_name']); ?></h1>

        <div class="attributes">
            <dl>
                <dt>Subject</dt>
                <dd><?php echo h($subject['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Menu Name</dt>
                <dd><?php echo h($page['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd><?php echo h($page['position']); ?></dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><?php echo h($page['visible']) == '1' ? 'true' : 'false'; ?></dd>
            </dl>
            <div class="actions">
                <a class="action" href="<?php echo url_for('/index.php?id=' . h(u($page['id'])) . '&preview=true'); ?>"
                    target="_blank">Preview</a>
            </div>
        </div>
    </div>
</div>

<?php require(SHARED_PATH . "/staff-footer.php"); ?>
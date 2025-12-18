<?php require_once("../../private/initialize.php"); ?>

<?php require_login(); ?>

<?php $pageTitle = "Staff Menu"; ?>

<?php require(SHARED_PATH . "/staff-header.php"); ?>

<div id="content">
    <div id="main-menu">
        <h2>Main Menu</h2>
        <ul>
            <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
            <li><a href="<?php echo url_for('/staff/admins/index.php'); ?>">Admins</a></li>
        </ul>
    </div>
</div>

<?php require(SHARED_PATH . "/staff-footer.php"); ?>
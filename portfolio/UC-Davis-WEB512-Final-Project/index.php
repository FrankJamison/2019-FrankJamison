<!DOCTYPE HTML>
<html>

<!-- HTML Head -->
<?php require_once("./includes/htmlhead.inc.php"); ?>

<body>
	<div id="main">

		<!-- Page Header -->
		<div id="header">

			<!-- Page Logo -->
			<?php require_once("./includes/logo.inc.php"); ?>

			<!-- Page Navigation -->
			<div id="menubar">
				<ul id="menu">
					<li class="selected"><a href="index.php">Home</a></li>
					<li><a href="autorss.php?pl=classic">Classic RSS</a></li>
					<li><a href="autorss.php?pl=vintage">Vintage RSS</a></li>
					<li><a href="autorss.php?pl=motorcycle">Motorcycle RSS</a></li>
					<li><a href="createaccount.php">Create Account</a></li>
					<li><a href="login.php">Login</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">
				<h2>Welcome to Frank's Classic Cars</h2>
				<p>We are the largest Classic and Exotic Car Sales Company in the world specializing in classic,
					collector, antique, exotic and race cars in our complete indoor showroom. Financing offered on all
					vehicles to qualified buyers.</p>
				<ul>
					<li>If you are a new employee, please use the &quot;CreateAccount&quot; menu item to set up an
						employee account.
					</li>
					<li>If you already have an employee account, use the &quot;Login&quot; menu item to log in.</li>
					<li>If you are not an employee, please feel free to subscribe to one of our RSS feeds.</li>
				</ul>
			</div>

		</div>

		<!-- Page Footer -->
		<?php require_once("./includes/footer.inc.php"); ?>

	</div>
</body>

</html>
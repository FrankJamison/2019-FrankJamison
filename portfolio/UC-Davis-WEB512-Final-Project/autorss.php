<?php

// Variable Include
require_once("./includes/variables.inc.php");

// Connection to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// GET Product Information
if (isset($_GET['pl'])) {

	// Set Product Number
	$input = trim($_GET['pl']);

	if ($input == 'classic') {
		$productLine = 'Classic Cars';
	} elseif ($input == 'vintage') {
		$productLine = 'Vintage Cars';
	} else {
		$productLine = 'Motorcycles';
	}
}

// PHP Header Info
header('Content-type: text/xml');

// Document Type
echo '<?xml version="1.0" encoding="utf-8"?>';

// Build Date
$buildDate = gmdate(DATE_RSS, time());

?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

	<channel>

		<!-- RSS Feed Info -->
		<title><?= $productLine ?> RSS</title>
		<atom:link href="http://<?= $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>" rel="self"
			type="application/rss+xml" />
		<link>http://frankjamison.com/173WEB512/Final/index.php</link>
		<description><?= $productLine ?> RSS Feed</description>
		<lastBuildDate><?= $buildDate ?></lastBuildDate>
		<language>en-us</language>

		<?php

		// Database Query
		$query = "SELECT * 
				FROM products 
				WHERE productLine = '$productLine' 
				ORDER BY dateAdded 
				DESC LIMIT 10 ";

		// Query Result
		$result = mysqli_query($dbc, $query)
			or die('Error querying database');

		// Loop Through and Print Out Records
		while ($newArray = mysqli_fetch_array($result)) {

			// Set Local Product Variables
			$productCode = $newArray[productCode];
			$productName = $newArray[productName];
			$productLine = $newArray[productLine];
			$productScale = $newArray[productScale];
			$productVendor = $newArray[productVendor];
			$productDescription = $newArray[productDescription];
			$dateAdded = $newArray[dateAdded];

			$pubDate = date(DATE_RSS, strtotime($dateAdded));

			?>

			<item>

				<title><?php echo "$productCode - $productName"; ?></title>
				<description><?= $productDescription ?></description>
				<link>http://frankjamison.com/173WEB512/Final/product.php?pid=<?= $productCode ?></link>
				<guid isPermaLink="false">http://frankjamison.com/173WEB512/Final/product.php?pid=<?= $productCode ?></guid>
				<pubDate><?= $pubDate ?></pubDate>

			</item>

			<?php

		} // End While Loop
		
		?>

	</channel>

</rss>

<?php
mysqli_close($dbc);
?>
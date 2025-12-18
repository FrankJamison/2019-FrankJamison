<?php
// Field Validation Function
function fieldValidation($regex, $my_string)
{
	if (preg_match($regex, $my_string)) {
		return $my_string;
	} else {
		return false;
	}
} // End function fieldValidation($regex, $my_string)

function countNumCustomers($dbc)
{
	$query = "SELECT `creditLimit` FROM `customers`";
	$result = mysqli_query($dbc, $query)
		or die("Bad SQL for Credit Limits");

	$numCustomers = 0;

	while ($row = $result->fetch_assoc()) {
		$numCustomers++;
	}

	return $numCustomers;
} // End function countNumCustomers()

function fillCreditLimitArray($dbc)
{
	// Debug Flag
	$debug = true;

	$query = "SELECT `creditLimit` FROM `customers` WHERE `creditLimit` IS NOT NULL";
	$result = mysqli_query($dbc, $query)
		or die("Bad SQL for Credit Limits");

	$creditLimitArray = array();

	while ($row = $result->fetch_assoc()) {

		array_push($creditLimitArray, $row['creditLimit']);
	}

	return $creditLimitArray;
} // End function fillCreditLimitArray()

function fillGraphArray($creditLimitArray)
{
	$bar1 = $bar2 = $bar3 = $bar4 = $bar5 = 0;

	foreach ($creditLimitArray as $creditLimit) {
		if ($creditLimit == 0) {
			$bar1++;
		} elseif ($creditLimit <= 50000) {
			$bar2++;
		} elseif ($creditLimit <= 75000) {
			$bar3++;
		} elseif ($creditLimit <= 100000) {
			$bar4++;
		} else {
			$bar5++;
		}
	} // End foreach($creditLimitArray as $creditLimit)

	$graphArray = array(
		array("$0", $bar1),
		array("$1 to $50,000", $bar2),
		array("$50,001 to $75,000", $bar3),
		array("75,001 to $100,000", $bar4),
		array("Over $100,000", $bar5)
	);

	return $graphArray;
} // End function fillGraphArray($creritLimitArray)

function makeGraphScale($numCustomers)
{
	$scaleMax = round(($numCustomers / 5) + 20);

	return $scaleMax;
} // End function makeGraphScale($numCustomers)

function drawBarGraph($width, $height, $data, $maxValue, $fileName)
{

	// Create Empty Graph Image
	$img = imagecreatetruecolor($width, $height);

	// Set white background with blue text and gold graphics
	$backgroundColor = imagecolorallocate($img, 255, 255, 255); // white
	$borderColor = $textColor = imagecolorallocate($img, 201, 151, 0); // gold
	$barColor = imagecolorallocate($img, 0, 40, 85); // blue 

	// Fill the background
	imagefilledrectangle($img, 0, 0, $width, $height, $backgroundColor);

	// Draw the bars
	$barWidth = $width / ((count($data) * 2) + 1);
	for ($i = 0; $i < count($data); $i++) {
		imagefilledrectangle($img, ($i * $barWidth * 2) + $barWidth, $height, ($i * $barWidth * 2) + ($barWidth * 2), $height - (($height / $maxValue) * $data[$i][1]), $barColor);
		imagestringup($img, 5, ($i * $barWidth * 2) + $barWidth, $height - 5, $data[$i][0], $textColor);
	}

	// Draw rectangle around graph
	imagerectangle($img, 0, 0, $width - 1, $height - 1, $borderColor);

	// Draw range up left side of graph
	for ($i = 0; $i <= $maxValue; $i += 20) {
		imagestring($img, 5, 0, $height - ($i * ($height / $maxValue)), $i, $barColor);
	}

	// Write the graph image to a file
	imagepng($img, $fileName, 5);
	imagedestroy($img);
} // End function drawBarGraph($width, $height, $data, $maxValue, $fileName)

// Product List Output
function getProductList($dbc, $productLine, $limit, $offset)
{

	// Database Query
	$query = "SELECT * 
			FROM `products` 
			WHERE `productLine` = '$productLine'
			ORDER BY `productCode`
			ASC LIMIT $limit 
			OFFSET $offset ";

	// Query Result
	$result = mysqli_query($dbc, $query)
		or die('Error querying products database');

	// Output Variable
	$output = "\n";

	// Loop Through and Print Out Records
	while ($row = $result->fetch_assoc()) {
		unset($product);

		$output .= "\t\t\t\t\t<p>Product Code: " . $row['productCode'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Product Name: " . $row['productName'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Product Line: " . $row['productLine'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Product Scale: " . $row['productScale'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Product Vendor: " . $row['productVendor'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Product Description: " . $row['productDescription'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Quantity in Stock: " . $row['quantityInStock'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>Buy Price: " . $row['buyPrice'] . "</p>\n";
		$output .= "\t\t\t\t\t<p>MSRP: " . $row['MSRP'] . "</p>\n";
		$output .= "\t\t\t\t\t<br><hr><br><br>\n\n";

	}

	return $output;

} // End getProductList($dbc, $productLine, $limit, $offset)

// Get Dropdown List
function getDropdownList($dbc, $query, $tableColumn, $withNull)
{

	$result = mysqli_query($dbc, $query)
		or die("Bad SQL for Dropdown");

	$dropdownOptions = "<select name='$tableColumn'>\n";

	if ($withNull) {
		$dropdownOptions .= "\t\t\t\t\t\t\t\t\t\t\t<option value=''>None Selected</option>\n";
	}

	while ($row = $result->fetch_assoc()) {
		unset($dropdownOption);
		$dropdownOption = $row[$tableColumn];
		$dropdownOptions .= "\t\t\t\t\t\t\t\t\t\t\t<option value='" . $dropdownOption . "'>" . $dropdownOption . "</option>\n";
	}

	$dropdownOptions .= "\t\t\t\t\t\t\t\t\t\t</select>\n";

	return $dropdownOptions;
} // End getDropdownList($dbc, $query, $tableColumn)

// Product Pagination
function pagination($result, $page, $totalPages, $productLineEncoded)
{
	$pageLinks = "<div class='pagination'>\n";
	for ($i = 1; $i <= $totalPages; $i++) {
		if ($i == $page) {
			$pageLinks .= "\t\t\t\t\t\t<a href='inventory.php?page=" . $i . "&productLine=" . $productLineEncoded . "' class='active'>" . $i . "</a>\n";
		} else {
			$pageLinks .= "\t\t\t\t\t\t<a href='inventory.php?page=" . $i . "&productLine=" . $productLineEncoded . "'>" . $i . "</a>\n";
		}
	}
	;
	$pageLinks .= "\t\t\t\t\t</div>";

	return $pageLinks;
} // End pagination($result, $page, $totalPages, $productLineEncoded)
?>
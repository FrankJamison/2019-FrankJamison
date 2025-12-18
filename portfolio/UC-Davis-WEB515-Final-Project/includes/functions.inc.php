<?php
// Send Mail Function
function sendEmail($headers, $subject, $from, $to, $bodymsg)
{
	require_once "Mail.php";
	require_once "Mail/mime.php";

	$crlf = "\n";

	$host = "smtp.powweb.com";
	$port = 587;
	$username = "frank@frankjamison.com";
	$password = "res0@L78";

	$mime = new Mail_mime(array('eol' => $crlf)); //based on pear doc
	$mime->setHTMLBody($bodymsg);

	$body = $mime->getMessageBody(); //based on pear doc above
	$headers = $mime->headers($headers);

	$smtp = Mail::factory("smtp", array(
		"host" => $host,
		"port" => $port,
		"auth" => true,
		"username" => $username,
		"password" => $password
	)/*, '-f frank@frankjamison.com'*/);


	$mail = $smtp->send($to, $headers, $body);

	if (PEAR::isError($mail)) {
		// echo $mail->getMessage();
		return false;
	} else {
		// echo "Message sent successfully!";
		return true;
	}
	echo "\n";
}

// Get ability Modifier
function getAbilityModifier($abilityScore)
{
	//Ability modifier is (ability score / 2) - 5
	return floor($abilityScore / 2) - 5;
}

function convertCheckboxToBool($checkbox)
{

	// If checkbox is on return true, else return false
	if ($checkbox == "on") {
		return true;
	} else {
		return false;
	}
}


?>
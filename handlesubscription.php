<?php

$lang = isset($_GET['lang']) ? $_GET['lang'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";

if (!empty($lang) and ($lang == 'en'))
{
	require_once __DIR__ . '/includes/enlang.php';
}
else
{
	require_once __DIR__ . '/includes/cnlang.php';
}

if (empty($email))
{
	$response = $phrases['subscribe_no_email'];
}
else
{
	$email = trim($email);

	//$emailRegex = ">(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])>i";

	//if (preg_match($emailRegex, $_POST['email']))
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$to      = "announcements-subscribe-" . str_replace('@', '=', $email) . '@hexbusiness.net';
		$from    = $email;
		$subject = $from;
		$body    = $from;

		if ($response = mail($to, $subject, $body, array('From' => $from, 'Reply-To' => $from)))
		{
			$response = $phrases['subscribe_good'];
		}
		else
		{
			$response = $phrases['subscribe_error'];
		}
	}
	else
	{
		$response = $phrases['subscribe_invalid_email'];
	}
}

?>
<html>
<head>
	<link href="./static/css/additional.css" rel="stylesheet">
	<link href="./static/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="./static/css/basic.css?v=0.0.1">

</head>
<body>
<div class="App" style="height:500px">
	<?php echo "<p class='align-content-center'>" . $response . "</p>"  ?>
</div>
</body>

</html>

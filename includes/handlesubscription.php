<?php
include_once __DIR__.'/base.php';
include_once __DIR__.'/global.php';

$lang = isset($_GET['lang']) ? $_GET['lang'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";

if (!empty($lang) and ($lang == 'en'))
{
	require_once __DIR__ . '/language/enlang.php';
}
else
{
	require_once __DIR__ . '/language/cnlang.php';
}


class HandleSubscription extends Base
{
	public function __construct()
	{
		$this->verifyToken();	
	}

	public function subscribe(string $lang, string $email, array $phrases): string {

		if (empty($email))
		{
			$response = $phrases['subscribe_no_email'];
		}
		else
		{
			$email = trim($email);
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			
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

		return $response;
	}
}

$obj = new HandleSubscription($lang, $email, $phrases);
$response = $obj->subscribe($lang, $email, $phrases);

?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="../static/css/additional.css" rel="stylesheet">
		<link href="../static/css/main.css" rel="stylesheet">
		<link rel="stylesheet" href="../static/css/basic.css?v=0.0.1">
	</head>
	<body>
	<div class="App" style="height:100%; padding: 100px;  display: flex; align-items: center; justify-content: center;">
		<?php echo "<p class='align-content-center; margin-top: -100px; '>" . $response . "</p>"  ?>
	</div>
	</body>

</html>
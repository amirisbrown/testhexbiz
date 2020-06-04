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

	public function subscribe(string $lang, string $email, array $phrases): string
	{
		if (empty($email))
		{
			return $phrases['subscribe_no_email'];
		}
		$email = trim($email);
		$emailRegex = "~[^\s]+@[^\s]{2,}\.[^\s]{2,}~";

		if (preg_match($emailRegex, $email))
		{
			//check for any of these bad characters
			foreach(str_split('!#$%&\*+/=?^_`{|}~<>') as $badchar)
			{
				if (mb_stripos($email, $badchar))
				{
					return $phrases['subscribe_invalid_email'];
				}
			}

			//get the tld, which is after the last dot.
			$parts = explode('.', $email);

			if (count($parts) < 2)
			{
				return $phrases['subscribe_invalid_email'];
			}
			$tld = $parts[count($parts) -1];
			unset($parts[count($parts) -1]);
			$email = implode('.', $parts);
			//now the domain.
			$parts = explode('@', $email);

			if (count($parts) < 2)
			{
				return $phrases['subscribe_invalid_email'];
			}
			$domainPos = count($parts) - 1;

			if (mb_stripos($parts[$domainPos], '.') !== false)
			{
				//not a valid domain.
				return $phrases['subscribe_invalid_email'];
			}
			$domain = $parts[$domainPos];
			unset($parts[$domainPos]);
			$email = implode('@', $parts);
			//This looks wrong.  it looks like it should be mb_strlen.  But the spec says 64 bytes not chars
			if ((strlen($email) > 64) OR ($email == ''))
			{
				return $phrases['subscribe_invalid_email'];
			}

			//if quoted it should start and end with a quote.
			if (mb_substr($email, 0, 1) == '"')
			{
				return $phrases['invalid_email_quoted'];
			}
			//if they got here it's probably valid.
			$domain .='.' . $tld;

			if (!mb_check_encoding($domain, 'ASCII'))
			{
				$domain  = idn_to_ascii($domain);
			}

			$email .= '@' . $domain;
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
			die('regex failed?');
			$response = $phrases['subscribe_invalid_email'];
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
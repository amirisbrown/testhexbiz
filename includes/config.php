<?php

include  __DIR__."/../autoload.php";

class Config
{
	public static  function getConfig()
	{

		return [
			'cachelife' => getenv('cachelife'), //life in seconds
			'etherscanApiKey' => getenv('etherscanApiKey'),
			'rateDataUrl' => getenv('rateDataUrl'),

		];
	}

	public static function getEtherConfig()
	{
		return [
		  "airdropContract" => getenv('airdropContract'),
		  "hexTokenAddress" => getenv('hexTokenAddress'),
		  "transferTopic" => getenv('transferTopic'),
		  "apiKey" => getenv('apiKey'),
		  "address" => getenv('address'),
		  "topic" => getenv('topic'),
		];
	}
}

<?php

require_once  __DIR__ . '/config.php';

class CurrentRates{
	protected $config = array();
	protected $emptyData = ['lastUpdated' => '',
							'hexUsd' => 0, 'hexBtc' => 0, 'hexEth' => 0,
							'btcUsd' => 0, 'ethUsd' => 0, 'hexTotalSupply' => 0,
							'hexLockedSupply' => 0, 'hexCirculatingSupply' => 0, 'adoptionAmplifierCurrentEth' => 0,
							'adoptionAmplifierCurrentHexEth' => 0, 'uniswapHexEth' => 0, 'hexUsd24Change' => 0,
							'hexBtc24Change' => 0, 'hexEth24Change' => 0, 'btcUsd24Change' => 0,
							'ethUsd24Change' => 0, 'hexTotalSupply24Change' => 0, 'hexLockedSupply24Change' => 0,
							'hexCirculatingSupply24Change' => 0, 'adoptionAmplifierCurrentEth24Change' => 0, 'adoptionAmplifierCurrentHexEth24Change' => 0,
							'uniswapHexEth24Change' => 0,];
	protected $key = 'currentRateData';

	public function __construct()
	{
		$this->config = Config::getConfig();
	}

	protected function getFromServer()
	{
		$curl = curl_init($this->config['rateDataUrl']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);

		try
		{
			$data = curl_exec($curl);
			$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if ($status <> 200)
			{
				return $this->emptyData;
			}

			if (empty(curl_error($curl)))
			{
				try
				{
					//for some reason I'm getting a number (always 60 so far) after the json string.
					while (substr($data, -1, 1) != '}')
					{
						$data = substr($data,0, -1);
					}
					$output = json_decode($data, true);
					//apcu_store($this->key, $output, $this->config['cachelife']);
					curl_close($curl);
					return $output;
				}
				catch (Exception $e)
				{
					//would but a return here but the next line is return.
				}
			}
			curl_close($curl);
			return $this->emptyData;
		}
		catch (Exception $e)
		{
			return $this->emptyData;
		}
	}

	public function getRateData()
	{
		try
		{
		/*	if ($data = apcu_fetch($this->key))
			{
				echo "got from cache\n";
				return $data;
			}
		 */
			if ($data = $this->getFromServer())
			{
				return $data;
			}
			return $this->emptyData;
		}
		catch (Exception $e)
		{
			return $this->emptyData;
		}

	}
}

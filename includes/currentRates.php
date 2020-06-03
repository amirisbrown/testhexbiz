<?php
class CurrentRates{
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
   	public function __construct(Config $config)
   	{
   		$this->config = $config;
   	}
    /**
     * Get Rate data
     *
     * @return array
    */
   	protected function getFromServer():array
    {  
		$curl = curl_init($this->config->getRateDataUrl());
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);

        $data = curl_exec($curl);
		if($data===false) {
		    throw new InvalidArgumentException("An error occurred when communicated with the rate server");
		}

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($status!==200) {
            return $this->emptyData;
        }

        while (substr($data, -1, 1) != '}')
        {
            $data = substr($data,0, -1);
        }
        $output = json_decode($data, true);
        return !empty($output) ? $output : $this->emptyData;
   }
    /**
     * Return data
     *
     * @return array
    */
   public function getRateData():array
   {
      return $this->getFromServer();
   }
}
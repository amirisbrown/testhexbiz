<?php

include_once  __DIR__."/../autoload.php";

class Config
{
    private function parseEnv(string $key, string $errorMessageUponFailure):string
    {
        if(empty($key) || empty($errorMessageUponFailure)) {
            throw new InvalidArgumentException("The parameters key and errorMessageUponFailure are required");
        }
        $value = getenv($key);
        if($value===false || empty($value)) {
            throw new InvalidArgumentException($errorMessageUponFailure);
        }
        return $value;
    }
    public function getRateDataUrl():string
    {
        return $this->parseEnv("rateDataUrl", "rateDataUrl missing");
    }
    public function getEtherConfigAirDropContract():string
    {
        return $this->parseEnv("airdropContract", "airdropContract missing");
    }
    public function getEtherConfigHexTokenAddress():string
    {
        return $this->parseEnv("hexTokenAddress", "hexTokenAddress missing");
    }
    public function getEtherConfigTransferTopic():string
    {
        return $this->parseEnv("transferTopic", "transferTopic missing");
    }
    public function getEtherConfigEtherApiKey():string
    {
        return $this->parseEnv("apiKey", "apiKey missing");
    }
    public function getEtherConfigAddress():string
    {
        return $this->parseEnv("address", "address missing");
    }
    public function getEtherConfigTopic():string
    {
        return $this->parseEnv("topic", "topic missing");
    }
}

  <?php
  include_once __DIR__.'/base.php';
  require_once  __DIR__ . '/config.php';
  
  Class Etherscan extends Base{

    private $config;

    public function __construct(Config $config)
    {
      $this->verifyToken();
      $this->config = $config;
    }

    /**
     * response etherscan api results
     *
     * @param  int  $id
     * @return Json
    */

    public function init() {

      $result = array();

      if(!isset($_POST['account']) && empty($_POST['account']) ){
          $result['status'] = 404;
      }
      else {
        $acc = trim($_POST['account']);

        try {
            $stats = $this->getAirdropStats($acc);
        } catch (Exception $e) {
            $stats = "invalid";
        }

        try {
            $total = $this->getTotalAirdropped();
        } catch (Exception $e){
            $total = "invalid";
        }

        $result['status'] = 200;
        $result['stats'] = $stats;
        $result['total'] = $total;
      }

      echo json_encode($result);
    }

    /**
     * response HexAddress
     *
     * @param  string  $add
     * @return string
    */

    private  function toHexAddress(string $add): string
    {
      if (!empty($add) && strlen($add) >= 3) {
        return '0x000000000000000000000000' . substr($add, 2);  
      }

    }

    /**
     * response HexAddress
     *
     * @param  string  $add
     * @return string
    */

    private  function getAirdropStats(string $acc):int
    {
        $airdropContract = $this->config->getEtherConfigAirDropContract();
        $apiKey          = $this->config->getEtherConfigEtherApiKey();
        $address         = $this->config->getEtherConfigAddress();
        $topic           = $this->config->getEtherConfigTopic();

        $cURLConnection = curl_init();

        curl_setopt($cURLConnection, CURLOPT_URL, "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=10011880&toBlock=latest&address=".$address."&topic0=".$topic."&topic0_1_opr=and&topic1=".$this->toHexAddress($airdropContract)."&topic1_2_opr=and&topic2=".$this->toHexAddress($acc)."&apikey=".$apiKey);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('Content-Type: application/json' ));
        $res = curl_exec($cURLConnection);

        //an error occurred with the curl
        if(curl_errno($cURLConnection)) {
          throw new InvalidArgumentException("invalid");
        }

        $resultStatus = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
        curl_close($cURLConnection);
        if ($resultStatus!==200) {
          throw new InvalidArgumentException("invalid");
        }

        return $this->processTotalAirDropped($res);
    }

    /**
     * Processing Total Airdropped
     *
     * @param  string  $result
     * @return int
    */
    private function processTotalAirDropped(string $result):int
    {
        if(empty($result)) {
            throw new InvalidArgumentException("invalid");
        }
        $_totalAirdropped = 0;
        $jsonArrayResponse = json_decode($result);

        if(!property_exists($jsonArrayResponse, 'result') || !is_array($jsonArrayResponse->result)) {
            throw new InvalidArgumentException( "invalid");
        }

        foreach($jsonArrayResponse->result as $item) {
            if(!property_exists($item, 'data')) {
                throw new InvalidArgumentException("Invalid");
            }

            $_totalAirdropped += hexdec($item->data);

        }

        return $_totalAirdropped;
    }


    /**
     * Response Total Airdropped
     *
     * @return int
    */

    private function getTotalAirdropped():int
    {

        $airdropContract = $this->config->getEtherConfigAirDropContract();
        $apiKey          = $this->config->getEtherConfigEtherApiKey();
        $address         = $this->config->getEtherConfigAddress();
        $topic           = $this->config->getEtherConfigTopic();

        $cURLConnection = curl_init();

        curl_setopt($cURLConnection, CURLOPT_URL, "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=10011880&toBlock=latest&address=" . $address . "&topic0=" . $topic . "&topic0_1_opr=and&topic1=" . $this->toHexAddress($airdropContract) . "&apikey=" . $apiKey);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $res = curl_exec($cURLConnection);

        if (curl_errno($cURLConnection)) {
          throw new InvalidArgumentException("invalid");
        }

        $resultStatus = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
        curl_close($cURLConnection);

        if ($resultStatus !== 200) {
            throw new InvalidArgumentException("invalid");
        }

        return $this->processTotalAirDropped($res);
    }
  }

  $obj = new Etherscan(new Config);
  $obj->init();
?>
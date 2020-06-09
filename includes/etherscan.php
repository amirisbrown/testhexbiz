<?php
  include_once __DIR__.'/base.php';
  require_once  __DIR__ . '/config.php';
  use GuzzleHttp\Client;
  use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

  Class Etherscan extends Base
  {

    private $config;

    public function __construct(Config $config)
    {
      $this->config = $config;
    }

    /**
     * response etherscan api results
     *
     * @param  int  $id
     * @return Json
    */

    public function init(): void {

      if(isset($_POST['account']) && !empty($_POST['account']) ){

        $this->verifyToken();
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
        echo json_encode($result);

      }

      
    }

    public function initwithoutJS($acc): array {

      $result = array();

      try {
            if(isset($acc) && !empty($acc))
              $stats = $this->getAirdropStats($acc);
            else
            $stats = "invalid";
      } catch (Exception $e) {echo $e;
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

      return $result;

    }

    /**
     * response HexAddress
     *
     * @param  string  $add
     * @return string
    */

    private function toHexAddress(string $add): string
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

    private  function airdropStats(string $acc, $airdropContract):int
    {
        $apiKey          = $this->config->getEtherConfigEtherApiKey();
        $address         = $this->config->getEtherConfigAddress();
        $topic           = $this->config->getEtherConfigTopic();
        $client = new Client();

        $uri = "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=10011880&toBlock=latest&address=".$address."&topic0=".$topic."&topic0_1_opr=and&topic1=".$this->toHexAddress($airdropContract)."&topic1_2_opr=and&topic2=".$this->toHexAddress($acc)."&apikey=".$apiKey;
        try{
          $response = $client->request('GET',$uri );
          if($response->getStatusCode()==200)
          {
              $data = json_decode($response->getBody(), true);
              return $this->processTotalAirDropped($data );        
          }
          else throw new InvalidArgumentException("Invalid");
        }
        catch(RequestException  $e){
          throw new InvalidArgumentException("Invalid");
        }
        
        return 0;
         
    }

    private  function getAirdropStats($acc):int
    {
      $totalUserAirdropped = 0;
      if (empty($acc)) {
        throw new InvalidArgumentException("no account in airdrop stats");
      }
      else{
        $airdropContract = $this->config->getEtherConfigAirDropContract();
        if(!empty($airdropContract))
        {
          $airdropContracts = explode(",", $airdropContract);
          try{
            $totalUserAirdropped += $this->airdropStats($acc, $airdropContracts[0]);
            if(count($airdropContracts)==2)
             $totalUserAirdropped += $this->airdropStats($acc, $airdropContracts[1]);
          }
          catch (Exception $e){
            throw new InvalidArgumentException("invalid");
          }
         
          return $totalUserAirdropped;
        }
        else
        throw new InvalidArgumentException("no address in airdrop stats");
        
      }

    }
    /**
     * Processing Total Airdropped
     *
     * @param  string  $result
     * @return int
    */
    private function processTotalAirDropped(array $resultArray):int
    {
      
        if(!is_array($resultArray)) {
            throw new InvalidArgumentException("invalid");
        }
        $_totalAirdropped = 0;
        if(!$resultArray['result'] || !is_array($resultArray['result'])) {
            throw new InvalidArgumentException( "invalid");
        }
        foreach($resultArray['result'] as $item) {
            if(!$item['data']) {
                throw new InvalidArgumentException("Invalid");
            }

            $_totalAirdropped += hexdec($item['data']);

        }

        return $_totalAirdropped;
    }


    /**
     * Response Total Airdropped
     *
     * @return int
    */

    private function totalAirdropped($contractAddress):int
    {
      $apiKey          = $this->config->getEtherConfigEtherApiKey();
      $address         = $this->config->getEtherConfigAddress();
      $topic           = $this->config->getEtherConfigTopic();
      $client = new Client();
      $uri = "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=10011880&toBlock=latest&address=" . $address . "&topic0=" . $topic . "&topic0_1_opr=and&topic1=" . $this->toHexAddress($contractAddress) . "&apikey=" . $apiKey;
        try{
          $response = $client->request('GET',$uri );
          if($response->getStatusCode()==200)
          {
              
              $data = json_decode($response->getBody(), true);
              return $this->processTotalAirDropped($data);        
          }
          else throw new InvalidArgumentException("Invalid");
        }
        catch(RequestException  $e){
          throw new InvalidArgumentException("Invalid");
        }
        
        return 0;
      // $cURLConnection = curl_init();

      // curl_setopt($cURLConnection, CURLOPT_URL, "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=10011880&toBlock=latest&address=" . $address . "&topic0=" . $topic . "&topic0_1_opr=and&topic1=" . $this->toHexAddress($contractAddress) . "&apikey=" . $apiKey);
      // curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      // $res = curl_exec($cURLConnection);

      // if (curl_errno($cURLConnection)) {
      //   throw new InvalidArgumentException("invalid");
      // }

      // $resultStatus = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
      // curl_close($cURLConnection);

      // if ($resultStatus !== 200) {
      //     throw new InvalidArgumentException("invalid");
      // }

      // return $this->processTotalAirDropped($res);
     
  }
  private function getTotalAirdropped(){
    $totalAirdropped = 0;
    $airdropContract = $this->config->getEtherConfigAirDropContract();
    if(!empty($airdropContract))
      {
        $airdropContracts = explode(",", $airdropContract);
        try{
          $totalAirdropped += $this->totalAirdropped($airdropContracts[0]);
        
          if(count($airdropContracts)==2)
            $totalAirdropped += $this->totalAirdropped( $airdropContracts[1]);
        }
        catch (Exception $e){
          throw new InvalidArgumentException("invalid");
        }
        return $totalAirdropped;
      }
      else
      throw new InvalidArgumentException("no address in airdrop stats");
  }
}
  $etherscan = new Etherscan(new Config);
  $etherscan->init();
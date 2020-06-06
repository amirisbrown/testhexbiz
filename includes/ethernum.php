<?php
include_once __DIR__.'/session.php';
include_once __DIR__.'/base.php';
require_once  __DIR__ . '/config.php';
require_once  __DIR__."/../vendor/autoload.php";

use Web3\Web3;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
 
class Ethernum extends Base
{
    private const WALLET_ADDRESS = 'walletAddress';
    private $moneyInstance;
    private $tokenInstance;
    private $moneyAdderss;
    private $tokenAddress;
    private $account;
    public $frozenBalances = 0;
    public $freezeReward = 0;
    public $allowance = 0;
    public $lockedToken = 0;
    public $freezeTokenBalance = 0;
    public $hxyTransformed = 0;
    public $heartsTransformed = 0;
    public $totalSupply = 0;
    public $maxSupply = 0;
    public $accountBalance = 0;
    
    public function __construct(Config $config)
    {
      
      $this->verifyToken();  
     
      $provider = $config->getProvider();
      
      if (empty($provider)) {
        throw new InvalidArgumentException("ethernum node uri cannot be empty");
      }
     if(isset($_POST['account']) && !empty($_POST['account'])) {
        $this->setUserAccount($_POST['account']);
      }
      else if(isset($_SESSION[self::WALLET_ADDRESS]) && !empty($_SESSION[self::WALLET_ADDRESS])) {
        $this->setUserAccount($_SESSION[self::WALLET_ADDRESS]);
      }
      
      $web3 = new Web3(new HttpProvider(new HttpRequestManager($provider, 3)));
      $contract = new Contract($web3->provider, $config->getMoneyABI());
      $this->moneyAddress = $config->getMoneyAddress();
      $this->tokenAddress = $config->getEtherConfigAddress();
      $this->moneyInstance = $contract->at($this->moneyAddress);
      $this->tokenInstance = new Contract($web3->provider, $config->getTokenABI());

    }

    public function init(): void
    {
      if(isset($_POST['account'])&&!empty($_POST['account']))
        $this->setUserAccount($_POST['account']);
      
      if($this->isLogged())
      {
        $this->getTokenFrozenBalances();
        $this->getFreezingReward();
        $this->getAllowance();
        $this->getAccountBalance();
      }
     

      $this->getLockedToken();
      $this->getFrzoneTokenBalance();
      $this->getHxyTransformed();
      $this->getTotalSupply();
      $this->getMaxSupply();
      
      $this->getHeartsTransformed();
      $result = array();
    }

    private function sendResult($heartsTransformed): void
    { 
      $this->heartsTransformed = $heartsTransformed;
      $result = array();
      
      $result['frozenBalances'] = $this->frozenBalances;
      $result['freezeReward'] = $this->freezeReward;
      $result['allowance'] = $this->allowance;
      $result['lockedToken'] = $this->lockedToken;
      $result['freezeTokenBalance'] = $this->freezeTokenBalance;
      $result['hxyTransformed'] = $this->hxyTransformed;
      $result['heartsTransformed'] = $this->heartsTransformed;
      $result['totalSupply'] = $this->totalSupply;
      $result['maxSupply'] = $this->maxSupply;
      $result['accountBalance'] = $this->accountBalance;
      if(isset($_POST['account'])&&!empty($_POST['account']))
      echo json_encode($result);
    }

    /**
     * This function checks if the user is already logged
     * @return bool
     */
    private function isLogged():bool
    { 
        try {
            $this->getUserAccount();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function setUserAccount(string $address): void
    {
        if (empty($address)) {
            throw new InvalidArgumentException("Wallet Address cannot be empty");
        }
        $_SESSION[self::WALLET_ADDRESS] = $address;
    }
     
    /**
     * This function returns the user wallet address
     * @return string
     */
    private function getUserAccount(): string
    {
        if(!isset($_SESSION[self::WALLET_ADDRESS])) {
            throw new InvalidArgumentException("No record wallet address");
        }

        $wallet = trim($_SESSION[self::WALLET_ADDRESS]);
        if (empty($wallet)) {
            throw new InvalidArgumentException('No record wallet address');
        }

        return $wallet;
    }
    private function getTokenFrozenBalances(): void
    {
      $this->moneyInstance->call('tokenFrozenBalances',$this->getUserAccount(), function ($err, $result) {

        if(!empty($err))  {
          throw new InvalidArgumentException($err);
        }
        else {
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->frozenBalances = ($result[0]->value);  
          }
        }
        
      });
    }
    private function getFreezingReward(): void
    {
      $this->moneyInstance->call('calcFreezingRewards', ['from'=>$this->account], function ($err, $result) {
        if(!empty($err)) {
          throw new InvalidArgumentException($err);
        }
        else{
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->freezingReward = ($result[0]->value);
          }          
        }
      });
    }

    private function getAllowance(): void
    {
      $this->tokenInstance->at($this->tokenAddress)->call('allowance',$this->getUserAccount(), $this->moneyAddress, function ($err, $result) {
        if(!empty($err)) {
          throw new InvalidArgumentException($err);
        }
        else {
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->allowance = ($result[0]->value);
          }
        }
      });
    }
    private function getLockedToken(): void
    {
      $this->moneyInstance->call('lockedTokens', null, function ($err, $result) {
        if(!empty($err)) {
          throw new InvalidArgumentException($err);
        }
        else {
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->lockedToken = ($result[0]->value);
          }          
        }
      });
    }

    private function getFrzoneTokenBalance(): void
    {
      $this->moneyInstance->call('totalFrozenTokenBalance', null, function ($err, $result) {
        if(!empty($err)) {
          throw new InvalidArgumentException($err);
        }
        else {
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->freezeTokenBalance = ($result[0]->value);
          }          
        }
      });
    }

    private function getHxyTransformed(): void
    {
      $this->moneyInstance->call('totalHXYTransformed', null, function ($err, $result) {
        if(!empty($err)) {
          throw new InvalidArgumentException($err);
        }
        else {
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->hxyTransformed = ($result[0]->value);
          }          
        }
      });
    }

    private function getHeartsTransformed(): void
    {
      $this->moneyInstance->call('totalHeartsTransformed', null, function ($err, $result) {

        if(!empty($err)) {
          throw new InvalidArgumentException($err);
        }
        else
        {
          if (count($result) > 0 && property_exists($result[0], 'value')){
            $this->heartsTransformed = ($result[0]->value);
            $this->sendResult( ($result[0]->value));
          }          

        }
      });
    }
   
    private function getTotalSupply(): void
    {
        $this->moneyInstance->call('totalSupply', null, function($err,$result){
            if(!empty($err)) {
                throw new InvalidArgumentException($err);
            }
            else {
              if (count($result) > 0 && property_exists($result[0], 'value')){
                $this->totalSupply = ($result[0]->value);
              }                     
            }
            
        });
    }

    private function getMaxSupply(): void
    {
        $this->moneyInstance->call('_maxSupply', null, function($err,$result){
            if(!empty($err)) {
                throw new InvalidArgumentException($err);
            }
            else {
              if (count($result) > 0 && property_exists($result[0], 'value')){
                $this->maxSupply = ($result[0]->value);
              }                
            }
        });
    }

    private function getAccountBalance(): void
    {
        $this->moneyInstance->call('balanceOf',$this->getUserAccount(), function($err,$result){
          if(!empty($err)) {
              throw new InvalidArgumentException($err);
          }
          else {
            if (count($result) > 0 && property_exists($result[0], 'value')){
              $this->accountBalance = ($result[0]->value);
            }                              
          }
        });
    }
}

$ethernum = new Ethernum(new Config);
$ethernum->init();
 
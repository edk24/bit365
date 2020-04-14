<?php

namespace Bit365;

class Pay
{
  protected $url = 'http://47.56.177.238';
  protected $key; // 秘钥
  protected $merchantId; // 商户id
  private $sendData;

  /**
   * init
   *
   * @param [type] $merchantId 商户id
   * @param [type] $key apiKey
   */
  public function __construct($merchantId, $key)
  {
    $this->key = $key;
    $this->merchantId = $merchantId;
  }

  /**
   * 创建订单 (CNY买USDT)
   *
   * @param [type] $payAccount 收款帐号
   * @param [type] $payChannel 支付渠道 (alipay/wechat/union/gather)
   * @param [type] $thirdTradeNo 第三方订单号
   * @param [type] $payAmount 支付金额 (元)
   * @param integer $thirdUserId 第三方用户id
   * @return string
   */
  public function create($payAccount, $payChannel = 'alipay', $thirdTradeNo, float $payAmount, $thirdUserId = 1): Pay
  {
    $data['buySymbol'] = "USDT";
    $data['paySymbol'] = 'CNY';
    $data['payAccount'] = $payAccount; // 支付帐号
    $data['payChannel'] = $payChannel;
    $data['requestTime'] = (string) time() * 1000;
    $data['payAmount'] = (float) $payAmount;
    $data['thirdMerchantId'] = $this->merchantId;
    $data['thirdUserId']  = $thirdUserId;
    $data['thirdTradeNo'] = $thirdTradeNo;
    // sign
    ksort($data); // 
    $json = json_encode($data);
    $sign = md5($json . $this->key);
    // sign getd
    $data['requestSign'] = strtolower($sign); //签名

    $this->sendData = json_encode($data);
    return $this;
  }

  /**
   * 发起支付请求
   *
   * @return void
   */
  public function send()
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => sprintf('%s/trade/recharge/prepareRechargeTrade', $this->url),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $this->sendData,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
      )
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
  }


  /**
   * 查询人民币和USDT的兑换比例
   *
   * @return float
   */
  public  function rateUSDTCNY()
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => sprintf("%s/trade/recharge/rateUSDTCNY", $this->url),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    if ($json['status'] == 0) {
      return $json['data'];
    }
    return 0;
  }

  /**
   * 查询订单信息 (成功返回数据, 失败null)
   *
   * @param [type] $thirdTrade 第三方订单号
   * @return void
   */
  public function queryRechargeTrade($thirdTrade): ?array
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => sprintf("%s/trade/recharge/queryRechargeTrade?thirdMerchantId=%s&thirdTradeNo=%s", $this->url, $this->merchantId, $thirdTrade),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    if ($json['status'] == 0) {
      return $json['data'];
    }
    return null;
  }
}

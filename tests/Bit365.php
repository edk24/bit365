<?
require '../vendor/autoload.php';

use Bit365\Pay;

// 创建订单并发送请求
$order_no = substr(md5(time() . time()), 0, 16);
$a = new Pay('5', '');
var_dump($a->create('27029049', 'alipay', $order_no, 299, md5('4'))->send());

// 查询CNY和USDT的兑换比例
var_dump($a->rateUSDTCNY());

// 查询订单
var_dump($a->queryRechargeTrade($order_no));


// array(24) {
//   ["thirdMerchantId"]=>
//   string(1) "5"
//   ["thirdTradeNo"]=>
//   string(16) "0688e30f6a066274"
//   ["thirdUserId"]=>
//   string(32) "a87ff679a2f3e71d9181a67b7542122c"
//   ["thirdUserIp"]=>
//   NULL
//   ["payChannel"]=>
//   string(6) "alipay"
//   ["payAccount"]=>
//   string(8) "27029049"
//   ["payAmount"]=>
//   float(299)
//   ["paySymbol"]=>
//   string(3) "CNY"
//   ["payActualAmount"]=>
//   float(299)
//   ["buySymbol"]=>
//   string(4) "USDT"
//   ["requestTime"]=>
//   string(19) "2020-04-14 13:09:39"
//   ["tradeId"]=>
//   int(5576)
//   ["tradeNo"]=>
//   string(16) "2004140509395969"
//   ["tradeStatus"]=>
//   string(6) "create"
//   ["buyerReceiptAmount"]=>
//   float(41.6)
//   ["receiptAccountName"]=>
//   NULL
//   ["receiptAccountNumber"]=>
//   NULL
//   ["receiptQrCode"]=>
//   NULL
//   ["receiptBank"]=>
//   NULL
//   ["receiptBankBranch"]=>
//   NULL
//   ["receiptAutoPayQRCode"]=>
//   string(45) "https://qr.alipay.com/fkx189210xsifzr945on7d1"
//   ["createTime"]=>
//   string(19) "2020-04-14 13:09:40"
//   ["pastSecByNow"]=>
//   int(0)
//   ["receiptPayURL"]=>
//   string(78) "http://cz.gotoc365.com/payment?thirdMerchantId=5&thirdTradeNo=0688e30f6a066274"
// }

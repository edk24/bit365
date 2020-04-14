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

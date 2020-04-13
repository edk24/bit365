<?

/**
 * 数字格式化测试类
 * @author XinLiang
 */

require '../vendor/autoload.php';

use Bit365\Pay;

// 创建订单并发送请求
$order_no = md5(time());
$a = new Pay('27029049', 'Zack');
var_dump($a->create('27029049', 'alipay', $order_no, 0.01, md5(5))->send());

// 查询CNY和USDT的兑换比例
var_dump($a->rateUSDTCNY());

// 查询订单
var_dump($a->queryRechargeTrade($order_no));
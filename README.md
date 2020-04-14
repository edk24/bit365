# 365Bit

> 文档阅读: `word.pdf`

#### use

```php
// 创建订单并发送请求
$order_no = md5(time());
$a = new Pay('27029049', 'Zack');
var_dump($a->create('27029049', 'alipay', $order_no,299, 1)->send());

// 查询CNY和USDT的兑换比例
var_dump($a->rateUSDTCNY());

// 查询订单
var_dump($a->queryRechargeTrade($order_no));
```

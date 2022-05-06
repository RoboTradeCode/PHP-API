# PHP RoboTrade  API

PHP обертка для [формата данных](https://github.com/RoboTradeCode/awesome/wiki/%D0%A4%D0%BE%D1%80%D0%BC%D0%B0%D1%82-%D0%BE%D0%B1%D0%BC%D0%B5%D0%BD%D0%B0-%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D1%85).

## Содержимое

| Метод                                       | Описание                                       |
|---------------------------------------------|------------------------------------------------|
| [Api::__construct](#Api__construct)         | Создает экземпляр Api                          |
| [Api::getMicrotime](#ApigetMicrotime)       | Возвращает текущий timestamp в микросекундах   |
| [Api::createOrder](#ApicreateOrder)         | Создание ордера                                |
| [Api::generateOrder](#ApigenerateOrder)     | Генерирует ордер для createOrders()            |
| [Api::createOrders](#ApicreateOrders)       | Создание нескольких ордеров                    |
| [Api::cancelOrder](#ApicancelOrder)         | Отмена ордера                                  |
| [Api::cancelOrders](#ApicancelOrders)       | Отмена нескольких ордеров                      |
| [Api::cancelAllOrders](#ApicancelAllOrders) | Отмена всех открытых ордеров                   |
| [Api::getOrderStatus](#ApigetOrderStatus)   | Получить статус ордера                         |
| [Api::getBalances](#ApigetBalances)         | Информация о балансах активов.                 |
| [Api::orderInfo](#ApiorderInfo)             | Информация о создании, закрытие, статусе ордера |
| [Api::balances](#Apibalances)               | Информация о балансах (от гейта к ядру).       |
| [Api::orderbook](#Apiorderbook)             | Ордербук отправляемый гейтом ядру.             |
| [Api::error](#Apierror)                     | Сообщение об ошибке                            |

## Api





* Full name: \robotrade\Api


### Api::__construct

Создает экземпляр Api

```php
Api::__construct( string exchange, string algo, string node, string instance ): mixed
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `exchange` | **string** | Название биржи |
| `algo` | **string** | Название алгоритма |
| `node` | **string** | Нода (core или gate) |
| `instance` | **string** | Экземпляр |

**Пример**:
```php
$api = new \robotrade\Api("binance", "cross_3t_php", "core", "cross_3t");
````






---
### Api::getMicrotime

Возвращает текущий timestamp в микросекундах

```php
Api::getMicrotime(): int
```





**Возвращает:**: json





---
### Api::createOrder

Создание ордера

```php
Api::createOrder( string symbol, string type, string side, float amount, float price, string|null message = null ): string
```




**Параметры:**

| Параметр | Type     | Описание |
|-----------|----------|-------------|
| `symbol` | **string** | Торговая пара |
| `type` | **string** | Тип (limit или market) |
| `side` | **string** | Направление сделки |
| `amount` | **float** | Количество |
| `price` | **float** | Цена |
| `message` | **string&#124;null** | Сообщение (необязательно) |

**Пример**:
```php
$create_order = $api->createOrder($symbol, $type, $side, $amount, $price);
````
**Возвращает:**: json





---
### Api::generateOrder

Генерирует ордер для createOrders()

```php
Api::generateOrder( string symbol, string type, string side, float amount, float price ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `symbol` | **string** | Торговая пара |
| `type` | **string** | Тип (limit или market) |
| `side` | **string** | Направление сделки |
| `amount` | **float** | Количество |
| `price` | **float** | Цена |


**Возвращает:**: json





---
### Api::createOrders

Создание нескольких ордеров.

```php
Api::createOrders( array orders, string|null message = null ): string
```

Ордера генерируются функцией generateOrder()


**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `orders` | **array** | Массив ордеров |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Пример**:
```php
$order_one = $api->generateOrder($symbol, $type, $side, $amount, $price);
$order_two = $api->generateOrder($symbol, $type, $side, $amount, $price);
$order_three = $api->generateOrder($symbol, $type, $side, $amount, $price);

$create_orders = $api->createOrders([$order_one, $order_two, $order_three]);
```

**Возвращает:**: json





---
### Api::cancelOrder

Отмена ордера

```php
Api::cancelOrder( string id, string symbol, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `id` | **string** | ID ордера |
| `symbol` | **string** | Торговая пара |
| `message` | **string&#124;null** | Сообщение (необязательно) |

**Пример**:
```php
$cancel_order = $api->cancelOrder($order_id, $symbol);
```

**Возвращает:**: json





---
### Api::cancelOrders

Отмена нескольких ордеров.
Структура массива ордеров:`[["id1", "symbol1"], ["id2", "symbol2"], ...]`

```php
Api::cancelOrders( array orders, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `orders` | **array** | Массив ордеров |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Пример**:
```php
$order_one = ["id" => 123, "symbol" => "BTC/USDT"];
$order_two = ["id" => 234, "symbol" => "ETH/USDT"];
$order_three = ["id" => 345, "symbol" => "ETH/BTC"];

$cancel_orders = $api->cancelOrders([$order_one, $order_two, $order_three]);
```

**Возвращает:**: json

---
### Api::cancelAllOrders
Отмена всех открытых ордеров

```php
Api::cancelAllOrders( string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Пример**:
```php
$cancel_all_orders = $api->cancelAllOrders();
```

**Возвращает:**: json


---
### Api::getOrderStatus

Получить статус ордера

```php
Api::getOrderStatus( string id, string symbol, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `id` | **string** | ID ордера |
| `symbol` | **string** | Торговая пара |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Возвращает:**: json

**Пример**:
```php
$get_order_status = $api->getOrderStatus($order_id, $symbol);
```



---
### Api::getBalances

Информация о балансах активов.

```php
Api::getBalances( array|null assets = null, string|null message = null ): string
```

Если массив активов пуст, возвращает информацию обо всех активах.


**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `assets` | **array&#124;null** | Массив активов [&quot;BTC&quot;, &quot;ETH&quot;, ...] |
| `message` | **string&#124;null** | Сообщение (необязательно) |

**Пример**:
```php
$get_balances = $api->getBalances(["BTC", "ETH", "WAVES"]);
```
**Возвращает:**: json



---
### Api::orderInfo

Информация о создании, закрытие, статусе ордера

```php
Api::orderInfo( string action, string id, int timestamp, string status, string symbol, string type, string side, float amount, float price, float filled, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `action` | **string** | Действие (order_created, order_closed или order_status) |
| `id` | **string** | ID ордера |
| `timestamp` | **int** | Таймстамп создания/закрытия или статуса |
| `status` | **string** | Текущий статус (open, closed или canceled) |
| `symbol` | **string** | Торговая пара |
| `type` | **string** | Тип (limit или market) |
| `side` | **string** | Направление сделки |
| `amount` | **float** | Количество |
| `price` | **float** | Цена |
| `filled` | **float** | Текущая заполненность |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Пример**:
```php
$order_closed = $api->orderInfo("order_closed", $order_id, $api->getMicrotime(), "closed", $symbol, $type, $side, $amount, $price, 0);
```

**Возвращает:**: json





---
### Api::balances

Информация о балансах (от гейта к ядру).

```php
Api::balances( array balances, string|null message = null ): string
```

Структура массива балансов: `["BTC" => ["free" => 0.0123, "used" => 0, "total" => 0.0123], ...]`


**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `balances` | **array** | Массив балансов |
| `message` | **string&#124;null** | Сообщение (необязательно) |

**Пример**:
```php
$balances = [
    "BTC" => ["free" => 0.0123, "used" => 0, "total" => 0.0123],
    "USDT" => ["free" => 321.00, "used" => 234.00, "total" => 555.00],
    "ETH" => ["free" => 1.05, "used" => 0.05, "total" => 1.1]
];

$balances = $api->balances($balances);
```

**Возвращает:**: json





---
### Api::orderbook

Ордербук отправляемый гейтом ядру.

```php
Api::orderbook( array orderbook, string symbol, int|null timestamp = null, string|null message = null ): string
```

Структура массива ордербука:
`["bids" => [[price, amount], ...],"asks" => [[price, amount], ...]]`


**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `orderbook` | **array** | Массив ордербука |
| `symbol` | **string** | Торговая пара |
| `timestamp` | **int&#124;null** | Таймстамп получения |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Пример**:
```php
$symbol = "BTC/USDT";

$orderbook = [
    'bids' => [
        [45564.23, 0.034],
        [45464.78, 0.14],
    ],
    'asks' => [
        [45361.12, 0.45],
        [45350.1, 0.00043],
    ]];

$orderbook = $api->orderbook($orderbook, $symbol);
```

**Возвращает:**: json





---
### Api::error

Сообщениe об ошибке

```php
Api::error( string action, mixed data = "", string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `action` | **string** | Действие при котором возникла ошибка |
| `data` | **mixed** | Данные об ошибке |
| `message` | **string&#124;null** | Сообщение об ошибке |

**Пример**:
```php
$error = $api->error("create_order", null, "Not enough balance");
```

**Возвращает:**: json





---

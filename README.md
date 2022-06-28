# PHP RoboTrade  API

PHP обертка для [формата обмена данными](https://github.com/RoboTradeCode/awesome/wiki/%D0%9E%D0%B1%D0%BC%D0%B5%D0%BD-%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D0%BC%D0%B8).

## Содержимое

| Метод                                         | Описание                                    |
|-----------------------------------------------|---------------------------------------------|
| [Api::__construct](#Api__construct)           | Создает экземпляр Api                       |
| [Api::getMicrotime](#ApigetMicrotime)         | Возвращает текущий timestamp в микросекундах |
| [Api::generateUUID](#ApigenerateUUID)         | Генерирует уникальный идентификатор UUID4   |
| [Api::createOrder](#ApicreateOrder)           | Создание ордера                             |
| [Api::generateOrder](#ApigenerateOrder)       | Генерирует ордер для createOrders()         |
| [Api::createOrders](#ApicreateOrders)         | Создание нескольких ордеров                 |
| [Api::cancelOrder](#ApicancelOrder)           | Отмена ордера                               |
| [Api::cancelOrders](#ApicancelOrders)         | Отмена нескольких ордеров                   |
| [Api::cancelAllOrders](#ApicancelAllOrders)   | Отмена всех открытых ордеров                |
| [Api::getOrderStatus](#ApigetOrderStatus)     | Получить статус ордера                      |
| [Api::getOrderStatuses](#ApigetOrderStatuses) | Получить статус нескольких ордеров          |
| [Api::getBalances](#ApigetBalances)           | Информация о балансах активов               |
| [Api::error](#Apierror)                       | Сообщение об ошибке                         |
| [Api::ping](#Apiping)                         | Главная метрика компонента                  |


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
### Api::generateUUID

Возвращает уникальный универсальный идентификатор UUID4 (36 символов)

```php
Api::generateUUID(): string
```





**Возвращает**: json



---
### Api::createOrder

Создание ордера

```php
Api::createOrder( string client_order_id, string symbol, string type, string side, float amount, float price, string|null message = null ): string
```




**Параметры:**

| Параметр | Type     | Описание                  |
|-----------|----------|---------------------------|
| `client_order_id` | **string** | Уникальный ID ордера      |
| `symbol` | **string** | Торговая пара             |
| `type` | **string** | Тип (limit или market)    |
| `side` | **string** | Направление сделки        |
| `amount` | **float** | Количество                |
| `price` | **float** | Цена                      |
| `message` | **string&#124;null** | Сообщение (необязательно) |

**Пример**:
```php
$client_order_id = $api->generateUUID();
$create_order = $api->createOrder($client_order_id, $symbol, $type, $side, $amount, $price);
````
**Возвращает**: json





---
### Api::generateOrder

Генерирует ордер для createOrders()

```php
Api::generateOrder( string client_order_id, string symbol, string type, string side, float amount, float price ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `client_order_id` | **string** | Уникальный ID ордера      |
| `symbol` | **string** | Торговая пара |
| `type` | **string** | Тип (limit или market) |
| `side` | **string** | Направление сделки |
| `amount` | **float** | Количество |
| `price` | **float** | Цена |


**Возвращает**: json





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
$client_order_id_one = $api->generateUUID();
$client_order_id_two = $api->generateUUID();
$client_order_id_three = $api->generateUUID();

$order_one = $api->generateOrder($client_order_id_one, $symbol, $type, $side, $amount, $price);
$order_two = $api->generateOrder($client_order_id_two, $symbol, $type, $side, $amount, $price);
$order_three = $api->generateOrder($client_order_id_three, $symbol, $type, $side, $amount, $price);

$create_orders = $api->createOrders([$order_one, $order_two, $order_three]);
```

**Возвращает**: json





---
### Api::cancelOrder

Отмена ордера

```php
Api::cancelOrder( string client_order_id, string symbol, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание                  |
|-----------|------|---------------------------|
| `client_order_id` | **string** | Уникальный ID ордера      |
| `symbol` | **string** | Торговая пара             |
| `message` | **string&#124;null** | Сообщение (необязательно) |

**Пример**:
```php
$cancel_order = $api->cancelOrder($client_order_id, $symbol);
```

**Возвращает**: json





---
### Api::cancelOrders

Отмена нескольких ордеров.
Структура массива ордеров:`[["client_order_id1", "symbol1"], ["client_order_id2", "symbol2"], ...]`

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
$order_one = ["client_order_id" => "23909aa5-e511-4e45-8960-98bdec5e13e9", "symbol" => "BTC/USDT"];
$order_two = ["client_order_id" => "7a6070ec-11e5-43bb-a2de-43f7a3f910d5", "symbol" => "ETH/USDT"];
$order_three = ["client_order_id" => "95f8d694-ed89-4f59-bc48-c9945d3b0025", "symbol" => "ETH/BTC"];

$cancel_orders = $api->cancelOrders([$order_one, $order_two, $order_three]);
```

**Возвращает**: json

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

**Возвращает**: json


---
### Api::getOrderStatus

Получить статус ордера

```php
Api::getOrderStatus( string id, string symbol, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание                  |
|-----------|------|---------------------------|
| `client_order_id` | **string** | Уникальный ID ордера      |
| `symbol` | **string** | Торговая пара             |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Возвращает**: json

**Пример**:
```php
$get_order_status = $api->getOrderStatus($client_order_id, $symbol);
```

### Api::getOrderStatuses

Запрос статусов нескольких ордеров.
Структура массива ордеров:`[["client_order_id1", "symbol1"], ["client_order_id2", "symbol2"], ...]`

```php
Api::getOrderStatuses( array orders, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип | Описание |
|-----------|------|-------------|
| `orders` | **array** | Массив ордеров |
| `message` | **string&#124;null** | Сообщение (необязательно) |


**Пример**:
```php
$order_one = ["client_order_id" => "23909aa5-e511-4e45-8960-98bdec5e13e9", "symbol" => "BTC/USDT"];
$order_two = ["client_order_id" => "7a6070ec-11e5-43bb-a2de-43f7a3f910d5", "symbol" => "ETH/USDT"];
$order_three = ["client_order_id" => "95f8d694-ed89-4f59-bc48-c9945d3b0025", "symbol" => "ETH/BTC"];

$cancel_orders = $api->getOrderStatuses([$order_one, $order_two, $order_three]);
```

**Возвращает**: json

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
**Возвращает**: json



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

**Возвращает**: json





---

---
### Api::ping

Генерирует сообщение для логгера с главной метрикой компонента
```php
Api::ping( int metric, string|null message = null ): string
```




**Параметры:**

| Параметр | Тип                  | Описание            |
|-----------|----------------------|---------------------|
| `metric` | **int**              | Главная метрика     |
| `message` | **string&#124;null** | Сообщение (необязательно)|

**Пример**:
```php
$error = $api->ping(31337);
```

**Возвращает**: json
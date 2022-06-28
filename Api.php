<?php

namespace robotrade;

class Api
{
    public string $exchange;
    public string $algo;
    public string $node;
    public string $instance;

    /**
     * Создает экземпляр Api
     *
     * @param string $exchange Название биржи
     * @param string $algo Название алгоритма
     * @param string $node Нода (core или gate)
     * @param string $instance Экземпляр
     */
    public function __construct(string $exchange, string $algo, string $node, string $instance)
    {
        $this->exchange = $exchange;
        $this->algo = $algo;
        $this->node = $node;
        $this->instance = $instance;
    }

    /**
     * Генерирует сообщение по базовому шаблону
     *
     * @param string $event
     * @param string $action
     * @param string $data
     * @param string|null $message
     * @return string
     * @throws \Exception
     */
    private function messageGenerator(string $event, string $action, string $data, string $message = null): string
    {
        return '{"event_id":"' . $this->generateUUID() . '",' .
            '"event":"' . $event . '",' .
            '"exchange":"' . $this->exchange . '",' .
            '"node":"' . $this->node . '",' .
            '"instance": "' . $this->instance . '",' .
            '"action":"' . $action . '",' .
            '"message":"' . $message . '",' .
            '"algo":"' . $this->algo . '",' .
            '"timestamp":' . $this->getMicrotime() . ',' .
            '"data":' . $data . '}';
    }

    /**
     * Возвращает текущий timestamp в микросекундах
     *
     * @return int
     */
    public function getMicrotime(): int
    {
        return intval(microtime(true) * 1000000);
    }

    /**
     * Возвращает уникальный UUID4
     *
     * @return string
     * @throws \Exception
     */
    public function generateUUID(): string
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Создание ордера
     *
     * @param string $client_order_id Уникальный ID для ордера
     * @param string $symbol Торговая пара
     * @param string $type Тип (limit или market)
     * @param string $side Направление сделки
     * @param float $amount Количество
     * @param float $price Цена
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function createOrder(string $client_order_id, string $symbol, string $type, string $side, float $amount, float $price, string $message = null): string
    {
        $event = "command";
        $action = "create_orders";

        $data = '[{"symbol":"' . $symbol . '",' .
            '"type":"' . $type . '",' .
            '"side":"' . $side . '",' .
            '"amount":' . $amount . ',' .
            '"price":' . $price . ',' .
            '"client_order_id":"' . $client_order_id . '"}]';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Генерирует ордер для createOrders()
     *
     * @param string $client_order_id Уникальный ID для ордера
     * @param string $symbol Торговая пара
     * @param string $type Тип (limit или market)
     * @param string $side Направление сделки
     * @param float $amount Количество
     * @param float $price Цена
     * @return string
     */
    public function generateOrder(string $client_order_id, string $symbol, string $type, string $side, float $amount, float $price): string
    {
        return '{"symbol":"' . $symbol . '",' .
            '"type":"' . $type . '",' .
            '"side":"' . $side . '",' .
            '"amount":' . $amount . ',' .
            '"price":' . $price . ',' .
            '"client_order_id":"' . $client_order_id . '"},';
    }

    /**
     * Создание нескольких ордеров.
     * Ордера генерируются функцией generateOrder()
     *
     * @param array $orders Массив ордеров
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function createOrders(array $orders, string $message = null): string
    {
        $event = "command";
        $action = "create_orders";

        $data = '[' . rtrim(implode('', $orders), ',') . ']';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Отмена ордера
     *
     * @param string $client_order_id ID ордера, сгенерированный при создании
     * @param string $symbol Торговая пара
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function cancelOrder(string $client_order_id, string $symbol, string $message = null): string
    {
        $event = "command";
        $action = "cancel_orders";

        $data = '[{"client_order_id":"' . $client_order_id . '","symbol":"' . $symbol . '"}]';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Отмена нескольких ордеров
     * Структура массива ордеров: [["client_order_id1", "symbol1"], ["client_order_id2", "symbol2"], ...]
     *
     * @param array $orders Массив ордеров
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function cancelOrders(array $orders, string $message = null): string
    {

        $event = "command";
        $action = "cancel_orders";

        $data = '[';

        foreach ($orders as $order) {
            $data .= '{"client_order_id":"' . $order['client_order_id'] . '","symbol":"' . $order['symbol'] . '"},';
        }

        $data = rtrim($data, ',') . ']';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Отмена всех открытых ордеров
     *
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function cancelAllOrders(string $message = null): string
    {
        $event = "command";
        $action = "cancel_all_orders";

        $data = '""';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Получить статус ордера
     *
     * @param string $client_order_id ID ордера, сгенерированный при создании
     * @param string $symbol Торговая пара
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function getOrderStatus(string $client_order_id, string $symbol, string $message = null): string
    {
        $event = "command";
        $action = "get_orders";

        $data = '[{"client_order_id":"' . $client_order_id . '","symbol":"' . $symbol . '"}]';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Запрос статуса нескольких ордеров
     * Структура массива ордеров: [["client_order_id1", "symbol1"], ["client_order_id2", "symbol2"], ...]
     *
     * @param array $orders Массив ордеров
     * @param string|null $message Сообщение (необязательно)
     * @return string
     */
    public function getOrderStatuses(array $orders, string $message = null): string
    {

        $event = "command";
        $action = "get_orders";

        $data = '[';

        foreach ($orders as $order) {
            $data .= '{"client_order_id":"' . $order['client_order_id'] . '","symbol":"' . $order['symbol'] . '"},';
        }

        $data = rtrim($data, ',') . ']';

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Информация о балансах активов.
     * Если массив активов пуст, возвращает информацию обо всех активах.
     *
     * @param array|null $assets Массив активов ["BTC", "ETH", ...]
     * @param string|null $message Сообщение (необязательно)
     * @return string
     * @throws \Exception
     */
    public function getBalances(array $assets = null, string $message = null): string
    {
        $event = "command";
        $action = "get_balance";

        if (is_array($assets) && count($assets) > 0) {
            $data = '[';

            foreach ($assets as $asset) {
                $data .= '"' . $asset . '",';
            }

            $data = rtrim($data, ',') . ']';
        } else {
            $data = '[]';
        }

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Сообщения об ошибке
     *
     * @param string $action Действие при котором возникла ошибка
     * @param null|string $data Данные об ошибке
     * @param string|null $message Сообщение об ошибке
     * @return string
     * @throws \Exception
     */
    public function error(string $action, null|string $data = "", string $message = null): string
    {
        $event = "error";

        $data = json_encode($data);

        return $this->messageGenerator($event, $action, $data, $message);
    }

    /**
     * Главная метрика компонента
     *
     * @param int $metric Инкриминируемая метрика компонента
     * @param string|null $message Сообщение об ошибке
     * @return string
     * @throws \Exception
     */
    public function ping(int $metric, string $message = null): string
    {
        $event = "data";
        $action = "ping";

        $data = $metric;

        return $this->messageGenerator($event, $action, $data, $message);
    }
}
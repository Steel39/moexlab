<?php

namespace App\Infrastructure\Repositories\Messaging\Trade;

use App\Infrastructure\Adapters\ClickhouseAdapter;
use App\Infrastructure\Adapters\RabbitMQAdapter;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPIOWaitException;
use PhpAmqpLib\Message\AMQPMessage;

class TradeMessageConsumer
{
    public $tradeData = [];

    public function __construct(
        private readonly ClickhouseAdapter $clickhouseAdapter,
        private readonly RabbitMQAdapter $rabbitMQAdapter,
    )
    {
    }

    public function consume(): void
    {
        $connection = $this->rabbitMQAdapter->getConnection();
        $channel = $connection->channel();
        $channel->queue_declare('trades_queue', false, true, false, false, false, []);
        $channel->exchange_declare('market', 'direct', false, true, false, false);
        $channel->queue_bind('trades_queue', 'market', 'trades_queue');
        $callback = function (AMQPMessage $msg) {
            $this->tradeData[] = json_decode($msg->body, true);
            if (count($this->tradeData) >= 5)
            {
                $click = $this->clickhouseAdapter->getConnection();
                $click->insert('trades', $this->tradeData);
            }

        };
        $channel->basic_consume('trades_queue', 'trades', false, false, false, false, $callback);

        while ($channel->getConnection()->isConnected())
        {
            try {
                $channel->wait();
            } catch (AMQPIOWaitException $exception)
            {
                echo $exception->getMessage();
            }
        }
        $channel->close();
        $connection->close();
    }

}

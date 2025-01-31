<?php

namespace App\Infrastructure\Repositories\Messaging\Trade;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Infrastructure\Adapters\RabbitMQAdapter;
use PhpAmqpLib\Message\AMQPMessage;

class TradeMessagePublish
{
    public function __construct(
        private readonly RabbitMQAdapter $adapter
    )
    {
    }

    public function execute(TradeDTO $message)
    {
        $connection = $this->adapter->getConnection();
        $channel = $connection->channel();
        $channel->exchange_declare('market', 'direct', false, true, false);
        $channel->queue_declare('trades_queue', false, true, false, false);
        $data = [
            'uid' => $message->instrument_uid->getUid(),
            'direction' => $message->direction->toInt(),
            'price' => $message->price->getFloatPrice(),
            'quantity' => $message->quantity->getQuantity(),
            'time' => $message->time->getSeconds(),
        ];
        $data = json_encode($data);
        $msg = new AMQPMessage($data,
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );
        $channel->basic_publish($msg, 'market', 'trades_queue');
        $channel->close();
        $connection->close();
    }
}

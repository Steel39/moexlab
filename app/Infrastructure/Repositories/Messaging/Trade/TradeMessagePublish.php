<?php

namespace App\Infrastructure\Repositories\Messaging\Trade;

use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Domain\Entity\Market\Trade;
use App\Infrastructure\Adapters\RabbitMQAdapter;
use PhpAmqpLib\Message\AMQPMessage;

class TradeMessagePublish
{
    public function __construct(
        private readonly RabbitMQAdapter $adapter
    )
    {
    }

    public function execute(Trade $message)
    {
        $connection = $this->adapter->getConnection();
        $channel = $connection->channel();
        $channel->exchange_declare('market', 'direct', false, true, false);
        $channel->queue_declare('trades_queue', false, true, false, false);
        $data = [
            'uid' => $message->getUid()->toString(),
            'direction' => $message->getDirection()->toInt(),
            'price' => $message->getPrice()->getFloatPrice(),
            'quantity' => $message->getVolume()->getValue(),
            'time' => $message->getTradeTime()->getSeconds(),
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

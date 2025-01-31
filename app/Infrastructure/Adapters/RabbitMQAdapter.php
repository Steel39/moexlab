<?php

namespace App\Infrastructure\Adapters;

use PhpAmqpLib\Connection\AMQPStreamConnection;

final readonly class RabbitMQAdapter
{

    public static function getConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USERNAME'),
            env('RABBITMQ_PASSWORD')
        );
    }
}

<?php

namespace Drupal\queue_worker\Services;

use Drupal\rabbitmq\Connection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class RabbitmqService.
 */
class RabbitmqService implements RabbitmqServiceInterface {

  /**
   * RabbitMQ connection.
   *
   * @var \Drupal\rabbitmq\Connection
   */
  protected $connection;

  /**
   * Constructs a new RabbitmqService object.
   */
  public function __construct(Connection $rabbitConnection) {
    $this->connection = $rabbitConnection->getConnection();
  }

  /**
   * {@inheritdoc}
   */
  public function pushMessage(string $queueName, array $data) {
    $channel = $this->connection->channel();
    $routing_key = $queue_name = $queueName;
    $channel->queue_declare($queue_name, FALSE, TRUE, FALSE, TRUE);
    $message = new AMQPMessage(json_encode($data));
    $channel->basic_publish($message, '', $routing_key);
    $channel->close();
    $this->connection->close();
  }

  /**
   * {@inheritdoc}
   */
  public function pushMessages(string $queueName, array $dataArray) {
    $channel = $this->connection->channel();
    $routing_key = $queue_name = $queueName;
    $channel->queue_declare($queue_name, FALSE, TRUE, FALSE, TRUE);
    foreach ($dataArray as $data) {
      $message = new AMQPMessage(json_encode($data));
      $channel->basic_publish($message, '', $routing_key);
    }
    $channel->close();
    $this->connection->close();
  }

}

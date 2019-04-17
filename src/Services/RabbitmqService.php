<?php

namespace Drupal\queue_worker\Services;

use Drupal\rabbitmq\Connection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPProtocolConnectionException;

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
    try {
      $this->connection = $rabbitConnection->getConnection();
    }
    catch (AMQPProtocolConnectionException $e) {
      \Drupal::logger(__CLASS__ . __LINE__)->notice(
        '@message', ['@message' => $e->getMessage()]
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function pushMessage(string $queueName, array $data) {
    if (empty($this->connection)) {
      \Drupal::logger(__CLASS__ . __LINE__)->notice(
        '@message', ['@message' => 'Empty connection']
      );
      return;
    }
    try {
      $channel = $this->connection->channel();
      $routing_key = $queue_name = $queueName;
      $channel->queue_declare($queue_name, FALSE, TRUE, FALSE, TRUE);
      $message = new AMQPMessage(json_encode($data));
      $channel->basic_publish($message, '', $routing_key);
      $channel->close();
      $this->connection->close();
    }
    catch (Exception $e) {
      \Drupal::logger(__CLASS__ . __LINE__)->notice(
        '@message', ['@message' => $e->getMessage()]
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function pushMessages(string $queueName, array $dataArray) {
    if (empty($this->connection)) {
      return;
    }
    try {
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
    catch (Exception $e) {
      \Drupal::logger(__CLASS__ . __LINE__)->notice(
        '@message', ['@message' => $e->getMessage()]
      );
    }
  }

}

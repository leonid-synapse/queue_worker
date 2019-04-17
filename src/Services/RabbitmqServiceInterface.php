<?php

namespace Drupal\queue_worker\Services;

/**
 * Interface RabbitmqServiceInterface.
 */
interface RabbitmqServiceInterface {

  /**
   * Отправить сообщение в очередь.
   *
   * @param string $queueName
   *   Название очереди.
   * @param array $data
   *   Данные для сообщения в очередь.
   */
  public function pushMessage(string $queueName, array $data);

  /**
   * Отправить сообщения в очередь.
   *
   * @param string $queueName
   *   Название очереди.
   * @param array $dataArray
   *   Данные с сообщениями очереди.
   */
  public function pushMessages(string $queueName, array $dataArray);

}

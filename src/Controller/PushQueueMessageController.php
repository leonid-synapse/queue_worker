<?php

namespace Drupal\queue_worker\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\queue_worker\Services\RabbitmqServiceInterface;

/**
 * Class PushQueueMessageController.
 */
class PushQueueMessageController extends ControllerBase {

  /**
   * Сервис для рэбита.
   *
   * @var Drupal\queue_worker\Services\RabbitmqServiceInterface
   */
  protected $rabbitmq;

  /**
   * Controller constructor.
   */
  public function __construct(RabbitmqServiceInterface $rabbitmq) {
    $this->rabbitmq = $rabbitmq;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('queue_worker.rabbitmq')
    );
  }

  /**
   * Push /queue_worker/push-queue-message.
   *
   * @return string
   *   Return Hello string.
   */
  public function push() {
    $this->rabbitmq->pushMessage('rabbitmq_lyagushka', [
      'action' => 'create_transaction',
      'data' => [
        'action' => 'test',
        'from' => 'korova',
        'date' => date('d.m.Y H:i:s'),
      ],
    ]);
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: push'),
    ];
  }

}

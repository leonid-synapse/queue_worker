<?php

namespace Drupal\queue_worker\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * QueueWorker.
 *
 * @QueueWorker(
 * id = "rabbitmq_korova",
 * title = "My custom Queue Worker",
 * )
 */
class ReveltimeQueueWorker extends QueueWorkerBase {

  /**
   * Processes a single item of Queue.
   */
  public function processItem($data) {

    \Drupal::logger(__FUNCTION__ . __LINE__)->notice(
      '@j', ['@j' => json_encode($data)]
    );

  }

}

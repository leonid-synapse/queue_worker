1. установить composer require 'drupal/rabbitmq:^1.1'
  (для 7-ки поправлен код в rabbitmq/rabbitmq.queue.inc, указан "'vhost' => '/'" в настройках подключения)


2. прописать настройки в /sites/default/settings.php

  $settings['rabbitmq_credentials'] = [
    'host' => '172.17.0.2',
    'port' => 5672,
    'username' => 'testrabbit',
    'password' => 'testtesttest',
    'vhost' => '/',
    'ssl' => FALSE,
  ];


3. для сайта указываем называние очереди, тут "rabbitmq_fazan"

  $settings['queue_service_rabbitmq_fazan'] = 'queue.rabbitmq';

  для 7-ки
  /**
   * Implements hook_init().
   */
  function queue_worker_init() {
    // Set a specific queue.
    variable_set('queue_class_rabbitmq_pchela', 'RabbitMQQueue');
  }


4. для ожидания подключения запускаем драш

  /usr/local/bin/drush -r /var/www/html rqwk rabbitmq_fazan --max_iterations=100

  для 7-ки
  /usr/local/bin/drush -r /var/www/html rabbitmq-worker rabbitmq_pchela --max_iterations=100


5. тестовая отправка сообщения тут

  path: '/queue_worker/push-queue-message'
  _controller: '\Drupal\queue_worker\Controller\PushQueueMessageController::push'

  для 7-ки
  $rabbitmq = new RabbitMQQueue($queueName);
  $rabbitmq->createItem($data);

<?php

use Monolog\Logger;

return array(
    'hosts' => array(
        '127.0.0.1:9200'
    ),
    'logPath' => app_path().'/storage/logs/elasticsearch.log',
    'logLevel' => Logger::INFO
);
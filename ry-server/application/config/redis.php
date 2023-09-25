<?php

$redis_config['redis_default']['host'] = 'localhost';     // IP address or host  
$redis_config['redis_default']['port'] = '6379';          // Default Redis port is 6379  
$redis_config['redis_default']['password'] = '';          // Can be left empty when the server does not require AUTH  
  
$redis_config['redis_slave']['host'] = '';  
$redis_config['redis_slave']['port'] = '6379';  
$redis_config['redis_slave']['password'] = '';  
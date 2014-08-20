<?php
$mc = new Memcached();
$mc->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
$mc->addServers(array_map(function($server) { return explode(':', $server, 2); }, explode(',', $_ENV['MEMCACHEDCLOUD_SERVERS'])));
$mc->setSaslAuthData($_ENV['MEMCACHEDCLOUD_USERNAME'], $_ENV['MEMCACHEDCLOUD_PASSWORD']);

switch ($_GET['a']) {
  case 'set':
    echo $mc->set('welcome_msg', 'Hello from Redis!');
    break;
  case 'get':
    echo $mc->get('welcome_msg');
    break;
  case 'stats':
    foreach ($mc->getStats() as $key => $value) {
      foreach ($value as $k => $v) {
        echo "$k: $v <br />\n";
      }
    }
    break;
  case 'delete':
    echo $mc->delete('welcome_msg');
    break;
  default:
    echo '';
    break;
}
?>

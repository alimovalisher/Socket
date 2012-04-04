<?php
require_once '../src/Aysheka/Socket/Socket.php';
require_once '../src/Aysheka/Socket/Server.php';
require_once '../src/Aysheka/Socket/Exception/SocketException.php';
require_once '../src/Aysheka/Socket/Listener.php';
require_once '../src/Aysheka/Socket/Client.php';

use Aysheka\Socket\Client;
use Aysheka\Socket\Socket;

$client = new \Aysheka\Socket\Client('127.0.0.1', 8088);
$client->send('dasdadd');
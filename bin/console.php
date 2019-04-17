<?php

require_once './vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new \Akuma\Tools\WebSocketEchoServer\Command\WebSocketEchoServerCommand());

$application->run();

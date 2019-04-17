<?php

namespace Akuma\Tools\WebSocketEchoServer\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\EchoServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WebSocketEchoServerCommand extends Command
{
    /** @var string */
    public const NAME = 'akuma:web-sockets:server';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->addOption('port', null, InputOption::VALUE_OPTIONAL, '', 8667)
            ->addOption('address', null, InputOption::VALUE_OPTIONAL, '', '0.0.0.0');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $address = $input->getOption('address');
        $port = $input->getOption('port');

        try {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new EchoServer()
                    )
                ),
                $port,
                $address
            );

            $server->run();

            $output->writeln(sprintf(
                '<info>Echo server up and waiting connections <info> on "%s:%s" at "%s"',
                $address,
                $port,
                (new \DateTime())->format('Y-m-d H:i:s')
            ));
        } catch (\Throwable $t) {
            $output->writeln(sprintf('<error>%s</error>' . $t->getMessage()));
        }
    }
}

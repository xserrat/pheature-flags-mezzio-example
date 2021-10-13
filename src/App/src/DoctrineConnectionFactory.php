<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;

class DoctrineConnectionFactory
{
    public function __invoke(ContainerInterface $container): Connection
    {
        $doctrineConfig = $container->get('config')['doctrine'];

        return DriverManager::getConnection($doctrineConfig);
    }
}

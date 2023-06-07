<?php

namespace ContainerJ5s7tgM;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrine_Dbal_DefaultConnectionService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'doctrine.dbal.default_connection' shared service.
     *
     * @return \Doctrine\DBAL\Connection
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/dbal/src/Connection.php';

        return $container->services['doctrine.dbal.default_connection'] = ($container->privates['doctrine.dbal.connection_factory'] ?? $container->load('getDoctrine_Dbal_ConnectionFactoryService'))->createConnection(['url' => $container->getEnv('resolve:DATABASE_URL'), 'dbname_suffix' => '_test'.$container->getEnv('string:default::TEST_TOKEN'), 'driver' => 'pdo_mysql', 'host' => 'localhost', 'port' => NULL, 'user' => 'root', 'password' => NULL, 'driverOptions' => [], 'defaultTableOptions' => []], ($container->privates['doctrine.dbal.default_connection.configuration'] ?? $container->load('getDoctrine_Dbal_DefaultConnection_ConfigurationService')), ($container->privates['doctrine.dbal.default_connection.event_manager'] ?? $container->load('getDoctrine_Dbal_DefaultConnection_EventManagerService')), []);
    }
}

<?php

namespace ContainerJ5s7tgM;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrine_Orm_DefaultEntityManagerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'doctrine.orm.default_entity_manager' shared service.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/common/src/Proxy/Autoloader.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Proxy/Autoloader.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/ManagerConfigurator.php';

        $container->services['doctrine.orm.default_entity_manager'] = $instance = new \Doctrine\ORM\EntityManager(($container->services['doctrine.dbal.default_connection'] ?? $container->load('getDoctrine_Dbal_DefaultConnectionService')), ($container->privates['doctrine.orm.default_configuration'] ?? $container->load('getDoctrine_Orm_DefaultConfigurationService')), ($container->privates['doctrine.dbal.default_connection.event_manager'] ?? $container->load('getDoctrine_Dbal_DefaultConnection_EventManagerService')));

        ($container->privates['doctrine.orm.default_manager_configurator'] ?? ($container->privates['doctrine.orm.default_manager_configurator'] = new \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator([], [])))->configure($instance);

        return $instance;
    }
}

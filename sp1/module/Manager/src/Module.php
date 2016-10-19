<?php

namespace Manager;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements ConfigProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
    
      public function getControllerConfig() {
        return [
            'factories' => [
            Controller\ManagerController::class => function($container) {
                    return new Controller\ManagerController(
                        $container->get(Model\ManagerTable::class)
                    );
                },
            ],
        ];
    }
}
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
     // Add this method:
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\LoginTable::class => function($container) {
                    $tableGateway = $container->get(Model\LoginTableGateway::class);
                    return new Model\LoginTable($tableGateway);
                },
                Model\LoginTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Login());
                    return new TableGateway('login', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    // Add this method:
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\LoginController::class => function($container) {
                    return new Controller\LoginController(
                        $container->get(Model\LoginTable::class)
                    );
                },
            ],
        ];
    }
}
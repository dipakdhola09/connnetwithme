<?php

namespace Agent;

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
            Controller\AgentController::class => function($container) {
                    return new Controller\AgentController(
                        $container->get(Model\AgentTable::class)
                    );
                },
                        
                 'Chat\Model\ChatTable' =>  function($container) {
                    $tableGateway = $container->get('ChatTableGateway');
                    $table = new ChattTable($tableGateway);
                    return $table;
                },
                        
                'ChatTableGateway' => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Chat());
                    return new TableGateway('chat', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}
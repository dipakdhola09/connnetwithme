<?php

namespace Manager;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Agent\Model\Agent;
use Agent\Model\AgentTable;

class Module implements ConfigProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    // Add this method:
    public function getServiceConfig() {
        return [
            'factories' => [
                Model\ManagerTable::class => function($container) {
                    $tableGateway = $container->get(Model\ManagerTableGateway::class);
                    return new Model\ManagerTable($tableGateway);
                },
                Model\ManagerTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Manager());
                    return new TableGateway('agent', $dbAdapter, null, $resultSetPrototype);
                },
              
                'Agent\Model\AgentTable' =>  function($container) {
                    $tableGateway = $container->get('AgentTableGateway');
                    $table = new AgentTable($tableGateway);
                    return $table;
                },
                        
                'AgentTableGateway' => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Agent());
                    return new TableGateway('agent', $dbAdapter, null, $resultSetPrototype);
                },
                
                Model\HelpTable::class => function($container) {
                    $tableGateway = $container->get(Model\HelpTableGateway::class);
                    return new Model\HelpTable($tableGateway);
                },
                Model\HelpTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Help());
                    return new TableGateway('help', $dbAdapter, null, $resultSetPrototype);
                },
                        
                Model\ChatcampaignTable::class => function($container) {
                    $tableGateway = $container->get(Model\ChatcampaignTableGateway::class);
                    return new Model\ChatcampaignTable($tableGateway);
                },
                Model\ChatcampaignTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Chatcampaign());
                    return new TableGateway('chat_campaigns', $dbAdapter, null, $resultSetPrototype);
                },
                    
                Model\ChatdesignTable::class => function($container) {
                    $tableGateway = $container->get(Model\ChatdesignTableGateway::class);
                    return new Model\ChatdesignTable($tableGateway);
                },
                        
                Model\ChatdesignTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Chatdesign());
                    return new TableGateway('chat_design', $dbAdapter, null, $resultSetPrototype);
                }
                
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
        
                Controller\ManagerController::class => function($container) {
                       return new Controller\ManagerController(
                            $container->get(Model\ManagerTable::class)
                    );
                },
                Controller\ChatsetupController::class => function($container) {
                       return new Controller\ChatsetupController(
                            $container->get(Model\HelpTable::class)
                    );
                },
                Controller\ChatdesignController::class => function($container) {
                       return new Controller\ChatdesignController(
                               $container->get(Model\ChatdesignTable::class)
                    );
                },        
            ],
        ];
    }

}

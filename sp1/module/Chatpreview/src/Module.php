<?php

/**
 * @author Akshay <akshay.vyas@people-tree.com>
 * @package Chat Preview Module
 * @name Manager
 * @access Manager 
 * @version Live Support S.P.1
 */

namespace Chatpreview;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
// Add this for SMTP transport
use Zend\ServiceManager\ServiceManager;
use Manager\Model\Chatbutton;
use Manager\Model\ChatbuttonTable;

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                \Manager\Model\ChatdesignTable::class => function($container) {
                    $tableGateway = $container->get(\Manager\Model\ChatdesignTableGateway::class);
                    return new \Manager\Model\ChatdesignTable($tableGateway);
                },
                \Manager\Model\ChatdesignTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Manager\Model\Chatdesign());
                    return new TableGateway('chat_design', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    /*
     * Config the controller
     */

    public function getControllerConfig() {
        return [
            'factories' => [
                Controller\ChatpreviewController::class => function($container) {
                    return new Controller\ChatpreviewController(
                            $container->get(\Manager\Model\ChatdesignTable::class)
                    );
                },
            ],
        ];
    }

}

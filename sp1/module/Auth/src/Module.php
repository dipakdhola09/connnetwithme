<?php

namespace Auth;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
// Add this for SMTP transport
use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
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
                Model\SignupTable::class => function($container) {
                    $tableGateway = $container->get(Model\SignupTableGateway::class);
                    return new Model\SignupTable($tableGateway);
                },
                Model\SignupTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Signup());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                Model\LoginTable::class => function($container) {
                    $tableGateway = $container->get(Model\LoginTableGateway::class);
                    return new Model\LoginTable($tableGateway);
                },
                Model\LoginTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Login());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                Model\ForgotTable::class => function($container) {
                    $tableGateway = $container->get(Model\ForgotTableGateway::class);
                    return new Model\ForgotTable($tableGateway);
                },
                Model\ForgotTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Forgot());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'Agent\Model\AgentTable' => function($container) {
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
                // Add this for SMTP transport
                'mail.transport' => function (ServiceManager $serviceManager) {

                    $options = array(
                        'host' => 'smtp.gmail.com',
                        'connection_class' => 'plain',
                        'connection_config' => array(
                            'username' => 'dev.livesuppport@gmail.com',
                            'password' => 'livesupport@123',
                            'ssl' => 'tls'
                        ),
                    );
                    //$config = $serviceManager->get('Config'); 
                    // print_r($config);exit;
                    $transport = new Smtp();
                    $transport->setOptions(new SmtpOptions($options));
                    return $transport;
                },
                    ],
                ];
            }

            // Add this method:
            /*
             * Config the controller
             */

            public function getControllerConfig() {
                return [
                    'factories' => [
                        Controller\SignupController::class => function($container) {
                            return new Controller\SignupController(
                                    $container->get(Model\SignupTable::class)
                            );
                        },
                        Controller\LoginController::class => function($container) {
                            return new Controller\LoginController(
                                    $container->get(Model\LoginTable::class)
                            );
                        },
                        Controller\ForgotpasswordController::class => function($container) {
                            return new Controller\ForgotpasswordController(
                                    $container->get(Model\ForgotTable::class)
                            );
                        },
                        Controller\DashboardController::class => function($container) {
                            return new Controller\DashboardController(
                                    //$container->get(Model\LoginTable::class)
                                    );
                        },
                    ],
                ];
            }

        }
        
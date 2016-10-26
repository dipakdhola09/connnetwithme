<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agent;

use Zend\Router\Http\Segment;

return [
  'router' => [
        'routes' => [
            
            //agent route
            'agent' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/agent[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\AgentController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    'view_manager' => [
      'display_not_found_reason' => true,
       'display_exceptions'       => true,
       'doctype'                  => 'HTML5',
       'not_found_template'       => 'error/404',
       'exception_template'       => 'error/index',
       'template_map' => [
           'layout/agent'            => __DIR__ . '/../view/layout/agent.phtml',
           'layout/chat'             => __DIR__ . '/../view/layout/agentChat.phtml',
           'error/404'               => __DIR__ . '/../view/error/404.phtml',
           'error/index'             => __DIR__ . '/../view/error/index.phtml',
       ],
       'template_path_stack' => [
           'agent' => __DIR__ . '/../view',
       ],
   ],
    
     'module_layouts' => array(
      'Agent' => array(
          'default' => 'layout/agent',
          'chat'    => 'layout/agentChat',
        )
     ),
];


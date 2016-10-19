<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager;

use Zend\Router\Http\Segment;

return [
  'router' => [
        'routes' => [
            
            //dashboard route
            'manager' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/manager[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ManagerController::class,
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
           'layout/manager'           => __DIR__ . '/../view/layout/manager.phtml',
           'manager/manager/index'       => __DIR__ . '/../view/manager/manager/index.phtml',
           'error/404'               => __DIR__ . '/../view/error/404.phtml',
           'error/index'             => __DIR__ . '/../view/error/index.phtml',
       ],
       'template_path_stack' => [
           'manager' => __DIR__ . '/../view',
       ],
   ],     
    
];


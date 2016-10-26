<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Chatpreview;

use Zend\Router\Http\Segment;

return [
  'router' => [
        'routes' => [
            //Sign up route
            
            'chatpreview' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/chatpreview[/:action[/:id]]',
                    'constraints' => [
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*', //action validation
                        'id'        => '[a-zA-Z][a-zA-Z0-9_-]*', //id validation   
                    ],
                    'defaults' => [
                        'controller' => Controller\ChatpreviewController::class,
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
           'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
           'chatpreview/chatpreview/index'       => __DIR__ . '/../view/chatpreview/chatpreview/index.phtml',
           //'error/404'               => __DIR__ . '/../view/error/404.phtml',
           //'error/index'             => __DIR__ . '/../view/error/index.phtml',
       ],
       'template_path_stack' => [
           'chatpreview' => __DIR__ . '/../view',
       ],
   ],     
    
];


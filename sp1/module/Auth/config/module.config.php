<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Auth;

use Zend\Router\Http\Segment;

return [
  'router' => [
        'routes' => [
            //Sign up route
            
            'signup' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/signup[/:action[/:id]]',
                    'constraints' => [
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*', //action validation
                        'id'        => '[a-zA-Z][a-zA-Z0-9_-]*', //id validation   
                    ],
                    'defaults' => [
                        'controller' => Controller\SignupController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            //Login route
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/login[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            
            'forgotpassword' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/forgotpassword[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ForgotpasswordController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            
            //dashboard route
            'dashboard' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/dashboard[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
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
           'layout/layout'           => __DIR__ . '/../view/layout/mylayout.phtml',
           'auth/signup/index'       => __DIR__ . '/../view/auth/signup/index.phtml',
           'error/404'               => __DIR__ . '/../view/error/404.phtml',
           'error/index'             => __DIR__ . '/../view/error/index.phtml',
       ],
       'template_path_stack' => [
           'auth' => __DIR__ . '/../view',
       ],
   ],     
    
];


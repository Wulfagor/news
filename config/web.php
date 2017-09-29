<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'dashboard' => [
            'class' => '@app/components/Dashboard',
            'items_resolutions' => [
                'Admin' => [
                    'profile' => [],
                    'manage_news' => [],
                    'manage_users' => []
                ],
                'ContentManager' => [
                    'profile' => [],
                    'manage_news' => []
                ],
                'User' => [
                    'profile' => []
                ]
            ],
            'items' => [
                'profile' => [
                    'name' => 'Profile',
                    'description' => 'View and edit profile data',
                    'icon' => 'glyphicon glyphicon-user',
                    'url' => '/private/view-profile'
                ],
                'manage_news' => [
                    'name' => 'News',
                    'description' => 'Manage news',
                    'icon' => 'glyphicons glyphicons-newspaper',
                    'url' => '/news/admin'
                ],
                'manage_users' => [
                    'name' => 'Users',
                    'description' => 'Manage users',
                    'icon' => 'glyphicons glyphicons-group',
                    'url' => '/user/admin/index'
                ],
                'manage_roles' => [
                    'name' => 'Roles',
                    'description' => 'Manage roles',
                    'icon' => 'glyphicons glyphicons-nameplate',
                    'url' => '/rbac/role/index'
                ]
            ]
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js',
                    ]
                ],
                'yii\jui\JuiAsset' => [
                    'js' => [
                        'jquery-ui.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js'
                    ]
                ],
            ],
            'converter' => [
                'class' => 'nizsheanez\assetConverter\Converter',
                'force' => true,
                'destinationDir' => '',
                'parsers' => [
                    'less' => [
                        'class' => 'nizsheanez\assetConverter\Less',
                        'output' => 'css',
                        'options' => [
                            'auto' => true,
                            'compressed' => true
                        ]
                    ]
                ]
            ]
        ],
        'request' => [
            'baseUrl' => '',
            'cookieValidationKey' => 'Z2FV3_e4gyVz6ajbGNQxU9n-tcCAGndz',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/custom_user',
                    '@dektrium/rbac/views' => '@app/views/custom_rbac'
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableRegistration' => true,
            'enablePasswordRecovery' => true,
            'enableConfirmation' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['administrator'],
            'controllerMap' => [
                'security' => 'app\controllers\custom_user\SecurityController',
                'registration' => 'app\controllers\custom_user\RegistrationController',
                'admin' => 'app\controllers\custom_user\AdminController'
            ]
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
            'controllerMap' => [
                'assignment' => 'app\controllers\custom_rbac\AssignmentController',
                'role' => 'app\controllers\custom_rbac\RoleController',
                'rule' => 'app\controllers\custom_rbac\RuleController',
                'permission' => 'app\controllers\custom_rbac\PermissionController'
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

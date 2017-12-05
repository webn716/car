<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2_api',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
    'modules' => [
        'gii'   => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['::1','127.0.0.1'], //只允许本地访问gii
            'generators'=> [
            /*重新定义gii model & crud的生成模板*/
            'module'=> [
                'class' => 'yii\gii\generators\module\Generator',
                'templates'=> [
                    'backend'=>'@common/gii/generators/module/default'
                ]
            ],
            'model'=> [
                'class' => 'yii\gii\generators\model\Generator',
                'baseClass'=> 'base\BaseActiveRecord',
                'ns'=> 'common\models',
                'templates'=> [
                    'common'=>'@common/gii/generators/model/default',
                    'backend'=>'@common/gii/generators/model/backend'
                ]
            ],
            'crud'=> [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates'=> [
                    'backend'=>'@common/gii/generators/crud/default'
                ],
                    'baseControllerClass' => 'BaseBackendController',
                    'messageCategory'=> 'backend'
                ]
            ]
        ]
    ]
];

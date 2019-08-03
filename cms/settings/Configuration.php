<?php
/**
 * Configuration
 *
 * author: Marc Scherer
 * package: census CMS
 */

define('BASE_DIR', $baseDir . DIRECTORY_SEPARATOR);
define('CONFIG_DIR', __DIR__ . DIRECTORY_SEPARATOR);
define('STORAGE_DIR', $baseDir . 'storage/');
define('PLUGIN_DIR', STORAGE_DIR . 'plugins/');
define('TEMPLATE_DIR', CONFIG_DIR . '../templates/');

return [
    'pagetreeRoot' => 'page',
    'cms' => [
        'controllerAction' => [
            'authentication' => [
                'login',
				'logout'
            ],
            'backend' => [
                'dashboard'
            ],
            'pagetree',
            'plugin',
            'login',
            'file',
            'user'
        ]
    ],
	'view' => [
		'template' => [
			'paths' => [
				TEMPLATE_DIR . 'backend/'
			]
		],
		'resources' => [
			'css' => [
				'authentication' => 'assets/stylesheets/login.css',
				'backend' => 'assets/stylesheets/backend.css'
			]
		]
	],
	'page' => [
		'charset' => 'UTF-8',
		'title' => [
			'prefix' => 'census CMS',
			'suffix' => ''
		]
	],
    'session' => [
        'expires' => '3600*2'
    ],
	'security' => [
		'salt' => ''
	]
];
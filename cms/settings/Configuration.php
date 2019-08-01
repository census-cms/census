<?php
/**
 * Configuration
 *
 * author: Marc Scherer
 * package: census CMS
 */

define('BASE_DIR', $baseDir . DIRECTORY_SEPARATOR);
define('CONFIG_DIR', __DIR__ . DIRECTORY_SEPARATOR);
define('STORAGE_DIR', $baseDir . '/storage/');
define('PLUGIN_DIR', STORAGE_DIR . '/plugins/');
define('TEMPLATE_DIR', CONFIG_DIR . '/../templates/');

return [
    'pagetreeRoot' => 'page',
    'cms' => [
        'controllerAction' => [
            'authentication' => [
                'login',
				'logout'
            ],
            'dashboard' => [
                'overview'
            ],
            'pagetree',
            'plugin',
            'login',
            'file',
            'user'
        ]
    ],
    'session' => [
        'expires' => '3600*2'
    ],
	'security' => [
		'salt' => ''
	]
];
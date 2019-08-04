<?php
return [
	'backend' => [
		'page' => [
			'label' => 'Pages'
		],
		'plugin' => [
			'label' => 'Plugins'
		],
		'file' => [
			'label' => 'Files'
		],
		'user' => [
			'label' => 'Users',
			'admin' => true
		]
	],
	'frontend' => [
		'themes' => [
			'label' => 'Theme Manager'
		]
	],
	'system' => [
		'config' => [
			'label' => 'Configuration',
			'admin' => true
		],
		'language' => [
			'label' => 'Languages',
			'admin' => true
		]
	],
	'profile' => [
		'profile' => [
			'label' => 'Edit'
		],
		'logout' => [
			'label' => 'Logout',
			'href' => '?cmd=authentication&action=logout'
		]
	]
];
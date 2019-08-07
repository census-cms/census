<?php
return [
	'backend' => [
		'page' => [
			'label' => 'Pages',
			'icon' => '039-file-text2.svg'
		],
		'plugin' => [
			'label' => 'Plugins',
			'icon' => '184-power-cord.svg'
		],
		'file' => [
			'label' => 'Files',
			'icon'=> '049-folder-open.svg'
		],
		'user' => [
			'label' => 'Users',
			'icon' => '115-users.svg',
			'admin' => true
		]
	],
	'frontend' => [
		'themes' => [
			'label' => 'Theme Manager',
			'icon' => '087-display.svg'
		]
	],
	'system' => [
		'config' => [
			'label' => 'Configuration',
			'icon' => '149-cog.svg',
			'admin' => true
		],
		'language' => [
			'label' => 'Languages',
			'icon' => '113-bubbles4.svg',
			'admin' => true
		]
	],
	'profile' => [
		'profile' => [
			'label' => 'Edit',
			'icon' => '114-user.svg'
		],
		'logout' => [
			'label' => 'Logout',
			'icon' => '276-enter.svg',
			'href' => '?cmd=authentication&action=logout'
		]
	]
];
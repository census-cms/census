<?php
if (version_compare(PHP_VERSION, '7.2.0', '<')) {
	throw new \Exception('cenus needs PHP 7.2 and above.');
}

call_user_func(function () {
	$classLoader = require '../../vendor/autoload.php';

    chdir('../');

	(new \CENSUS\Core\Application(getcwd()))->setClassLoader($classLoader);
});
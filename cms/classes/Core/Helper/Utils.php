<?php
namespace CENSUS\Core\Helper;

/**
 * Class Utils
 * Has some methods for re-use in different cases
 *
 * @package CENSUS\Core\Helper
 */
class Utils
{
	/**
	 * Dump a mixed var pre formatted
	 *
	 * @param mixed $var
	 */
	public static function dump($var)
	{
		echo '<pre style="position: relative; z-index: 1000; background: #333; color: #fff;">';
		var_dump($var);
		echo '</pre>';
	}

	/**
	 * Create a new object for the given className
	 *
	 * @param string $className
	 * @param array|null $params
	 */
	public static function newInstance($className, $params = null)
	{
		if (class_exists($className)) {
			$newReflectionClass = new \ReflectionClass($className);

			if (null !== $params) {
				$newReflectionClass->newInstanceArgs((array) $params);
			}
		} else {
			// @todo log, do not throw an exception
		}
	}
}
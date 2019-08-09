<?php
namespace CENSUS\Core\Helper;

/**
 * Class Yaml
 * A wrapper for the symfony YAML parser lib
 *
 * @package CENSUS\Core\Helper
 */
class Yaml
{
	/**
	 * Parses a YAML string to a PHP value
	 *
	 * @param string $value
	 * @param int $flags
	 * @return mixed
	 */
	public static function parse(string $value, int $flags = 0)
	{
		return (new \Symfony\Component\Yaml\Parser)->parse($value, $flags);
	}

	/**
	 * Parses a YAML file into a PHP value
	 *
	 * @param string $filename
	 * @param int $flags
	 * @return mixed
	 */
	public static function parseFile(string $filename, int $flags = 0)
	{
		return (new \Symfony\Component\Yaml\Parser)->parseFile($filename, $flags);
	}

	/**
	 * Dumps a PHP value to YAML
	 *
	 * @param $input
	 * @param int $inline
	 * @param int $indent
	 * @param int $flags
	 * @return string
	 */
	public static function dump($input, int $inline = 0, int $indent = 0, int $flags = 0)
	{
		return (new \Symfony\Component\Yaml\Dumper)->dump($input, $inline, $indent, $flags);
	}

	/**
	 * Get the YAML Dumper
	 *
	 * @return \Symfony\Component\Yaml\Dumper
	 */
	private function getYamlDumper()
	{
		/** @var \Symfony\Component\Yaml\Dumper $yamlDumper */

		return $yamlDumper;
	}
}
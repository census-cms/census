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
	 */
	public static function parse(string $value, int $flags = 0)
	{
		\Symfony\Component\Yaml\Parser::parse($value, $flags);
	}

	/**
	 * Parses a YAML file into a PHP value
	 *
	 * @param string $filename
	 * @param int $flags
	 */
	public static function parseFile(string $filename, int $flags = 0)
	{
		\Symfony\Component\Yaml\Parser::parseFile($filename, $flags);
	}

	/**
	 * Dumps a PHP value to YAML
	 *
	 * @param $input
	 * @param int $inline
	 * @param int $indent
	 * @param int $flags
	 */
	public static function dump($input, int $inline = 0, int $indent = 0, int $flags = 0)
	{
		self::getYamlDumper()->dump($input, $inline, $indent, $flags);
	}

	/**
	 * Get the YAML Dumper
	 *
	 * @return \Symfony\Component\Yaml\Dumper
	 */
	private function getYamlDumper()
	{
		/** @var \Symfony\Component\Yaml\Dumper $yamlDumper */
		$yamlDumper = \CENSUS\Core\Helper\Utils::newInstance('\\Symfony\\Component\\Yaml\\Dumper');
		return $yamlDumper;
	}
}
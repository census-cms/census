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
	 * @var \Symfony\Component\Yaml\Parser
	 */
	private $parser = null;

	/**
	 * @var \Symfony\Component\Yaml\Dumper
	 */
	private $dumper = null;

	public function __construct ()
	{
		$this->parser = \CENSUS\Core\Helper\Utils::newInstance('\\Symfony\\Component\\Yaml\\Parser');
		$this->dumper = \CENSUS\Core\Helper\Utils::newInstance('\\Symfony\\Component\\Yaml\\Dumper');
	}

	/**
	 * Parses a YAML string to a PHP value
	 *
	 * @param string $value
	 * @param int $flags
	 */
	public function parse(string $value, int $flags = 0)
	{
		$this->parser->parse($value, $flags);
	}

	/**
	 * Parses a YAML file into a PHP value
	 *
	 * @param string $filename
	 * @param int $flags
	 */
	public function parseFile(string $filename, int $flags = 0)
	{
		$this->parser->parseFile($filename, $flags);
	}

	/**
	 * Dumps a PHP value to YAML
	 *
	 * @param $input
	 * @param int $inline
	 * @param int $indent
	 * @param int $flags
	 */
	private function dump($input, int $inline = 0, int $indent = 0, int $flags = 0)
	{
		$this->dumper->dump($input, $inline, $indent, $flags);
	}
}
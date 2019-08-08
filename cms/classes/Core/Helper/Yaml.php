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

	public function parse()
	{
		$this->parser->parse();
	}

	public function parseFile()
	{
		$this->parser->parseFile();
	}

	private function dump()
	{
		$this->dumper->dump();
	}
}
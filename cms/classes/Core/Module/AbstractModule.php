<?php
namespace CENSUS\Core\Module;


abstract class AbstractModule
{
	/**
	 * @var array
	 */
	protected $configuration = [];

	/**
	 * AbstractModule constructor
	 *
	 * @param array $configuration
	 */
	public function __construct($configuration)
	{
		$this->configuration = $configuration;

		$this->initializeModule();
	}

	/**
	 * Initialize the module
	 */
	abstract protected function initializeModule();
}
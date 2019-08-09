<?php
namespace CENSUS\Core\Module;


abstract class AbstractModule
{
	/**
	 * @var \CENSUS\Model\Request
	 */
	protected $request = null;

	/**
	 * @var \CENSUS\Core\View
	 */
	protected $view = null;

	/**
	 * @var array
	 */
	protected $configuration = [];

	/**
	 * Initialize the module
	 */
	abstract protected function initializeModule();

	/**
	 * AbstractModule constructor
	 *
	 * @param \CENSUS\Model\Request $request
	 * @param \CENSUS\Core\View $view
	 * @param array $configuration
	 */
	public function __construct(\CENSUS\Model\Request $request, \CENSUS\Core\View $view, array $configuration)
	{
		$this->request = $request;
		$this->view = $view;
		$this->configuration = $configuration;

		$this->initializeModule();
		$this->handleModuleRequest();
	}

	/**
	 * Call the requested context for each module
	 */
	private function handleModuleRequest()
	{
		$context = $this->request->getArgument('context');
		$contextMethodName = $context . 'Context';

		if (null === $context) {
			$contextMethodName = 'indexContext';
		}

		if (method_exists($this, $contextMethodName)) {
			$this->$contextMethodName();
		}
	}
}
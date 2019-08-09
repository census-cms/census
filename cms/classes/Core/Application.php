<?php
namespace CENSUS\Core;

class Application
{
	/**
	 * @var \CENSUS\Core\Session
	 */
	private $session = null;

	/**
	 * Configuration
	 *
	 * @var \CENSUS\Core\Configuration
	 */
	private $configuration = null;

    /**
     * @var \CENSUS\Model\Request
     */
	private $request = null;

	/**
	 * @var \CENSUS\Core\View
	 */
    private $view = null;

	/**
	 * @var \CENSUS\Core\Plugin\Registry
	 */
    private $pluginRegistry = null;

	/**
	 * @var \Composer\Autoload\ClassLoader
	 */
	private $classLoader = null;

    /**
     * Application constructor
     *
     * @param string $baseDir
     */
	public function __construct (string $baseDir)
	{
		$this->initialize($baseDir);
	}

    /**
     * @param string $baseDir
     */
	private function initialize($baseDir)
	{
		$this->session = new \CENSUS\Core\Session();

		$this->startOutputBuffering();

		$this->configuration = new \CENSUS\Core\Configuration($this);
		$this->configuration->initializeConfiguration($baseDir);

		$this->initializeRequest();
		$this->initializeFormhandler();
		$this->initializeView();
		$this->initializeController();
		$this->initializeModule();
		$this->initializePluginRegistry();

        $this->flushOutputBuffering();
	}

	/**
	 * Initialize the request
	 */
	private function initializeRequest()
	{
		$this->request = (new \CENSUS\Core\Request($this->configuration->getConfig(), $this->session->isAuthenticated()))->getRequest();
	}

	/**
	 * Initialize the form handler
	 */
	private function initializeFormhandler()
	{
		if (true === $this->request->getPost()) {
			$this->formhandler = new \CENSUS\Core\Form\Handler($this->request);
		}
	}

	/**
	 * Initialize the view
	 */
	private function initializeView()
	{
		$this->view = new \CENSUS\Core\View($this->request, $this->configuration->getConfigByKey('view'));
	}

	/**
	 * Initialize the controller by command
	 */
	private function initializeController()
	{
		$command = (false === $this->session->isAuthenticated()) ? 'Authentication' : ucfirst($this->request->getArgument('cmd'));
		\CENSUS\Core\Helper\Utils::newInstance('\\CENSUS\\Core\\Controller\\' . $command . 'Controller', [$this->request, $this->view, $this]);
	}

	/**
	 * Initialize module
	 */
	private function initializeModule()
	{
		if (true === $this->session->isAuthenticated()) {
			$module = ucfirst($this->request->getArgument('mod'));
			\CENSUS\Core\Helper\Utils::newInstance('\\CENSUS\\Core\\Module\\' . $module, [$this->request, $this->view, $this->configuration->getConfig()]);
		}
	}

	private function initializePluginRegistry()
	{
		$this->pluginRegistry = \CENSUS\Core\Helper\Utils::newInstance('\\CENSUS\\Core\\Plugin\\Registry');
	}

	/**
	 * Initialize the logout
	 */
	public function initializeLogout()
	{
		$this->session->logout();
	}

	/**
	 * @param \CENSUS\Core\Configuration $classLoader
	 */
	public function setClassLoader($classLoader)
	{
		$this->classLoader = $classLoader;
	}

	/**
	 * Start the output buffering
	 */
	private function startOutputBuffering()
	{
		ob_start();
	}

	/**
	 * Flush the output buffering
	 */
	private function flushOutputBuffering()
	{
		ob_flush();
		ob_clean();
	}

	/**
	 * Get the configuration
	 *
	 * @return \CENSUS\Core\Configuration
	 */
	public function getConfiguration()
	{
		return $this->configuration;
	}
}
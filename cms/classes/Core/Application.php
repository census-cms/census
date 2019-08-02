<?php
namespace CENSUS\Core;

class Application
{
	/**
	 * Configuration
	 *
	 * @var \CENSUS\Core\Configuration
	 */
	private $configuration = null;

	/**
	 * @var \Composer\Autoload\ClassLoader
	 */
	private $classLoader = null;

	/**
	 * @var \CENSUS\Core\FileBase
	 */
	private $fileBase = null;

    /**
     * @var \CENSUS\Core\Request
     */
	private $request = null;

    /**
     * @var \CENSUS\Core\Session
     */
    private $session = null;

	/**
	 * User is authenticated
	 *
	 * @var bool
	 */
	private $isAuthenticated = false;

    /**
     * Application constructor
     *
     * @param string $baseDir
     */
	public function __construct ($baseDir)
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

		$this->isAuthenticated = $this->session->isAuthenticated();

		$this->configuration = new \CENSUS\Core\Configuration($this);
		$this->configuration->initializeConfiguration($baseDir);

		$this->fileBase = new \CENSUS\Core\FileBase($this->configuration->getConfigByKey('pagetreeRoot'));
		$this->request = new \CENSUS\Core\Request($this, $this->configuration->getConfig());

		$this->initializeController();

        $this->flushOutputBuffering();

        echo '<pre>';
        var_dump($this->session);
        echo '</pre>';
	}

	private function initializeController()
	{
		$requestedCommandControllerName = ucfirst($this->request->getCommand()) . 'Controller';
		$requestedCommandControllerClass = '\\CENSUS\\Core\\Controller\\' . $requestedCommandControllerName;

		if (class_exists($requestedCommandControllerClass)) {
			new $requestedCommandControllerClass(
				$this->request->getRequest(),
				$this
			);
		}
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

	/**
	 * Get the FileBase
	 * 
	 * @return \CENSUS\Core\FileBase
	 */
	public function getFileBase()
	{
		return $this->fileBase;
	}

	/**
	 * Check authentication status
	 *
	 * @return bool
	 */
	public function getIsAuthenticated()
	{
		return $this->isAuthenticated;
	}

	/**
	 * Get the current command
	 *
	 * @return string|null
	 */
	public function getCommand()
	{
		return $this->request->getCommand();
	}

	/**
	 * Get the current action
	 *
	 * @return null
	 */
	public function getAction()
	{
		return $this->request->getAction();
	}

	/**
	 * Initialize the logout command
	 */
	public function initializeLogout()
	{
		$this->session->logout();
	}
}
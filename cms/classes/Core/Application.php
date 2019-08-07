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
     * @var \CENSUS\Model\Request
     */
	private $request = null;

    /**
     * @var \CENSUS\Core\Session
     */
    private $session = null;

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

		$this->configuration = new \CENSUS\Core\Configuration($this);
		$this->configuration->initializeConfiguration($baseDir);

		//$this->fileBase = new \CENSUS\Core\FileBase($this->configuration->getConfigByKey('pagetreeRoot'));
		$this->request = (new \CENSUS\Core\Request($this->configuration->getConfig(), $this->session->isAuthenticated()))->getRequest();

		$this->initializeController();
		$this->initializeModule();

        $this->flushOutputBuffering();
	}

	/**
	 * Initialize the controller by command
	 */
	private function initializeController()
	{
		$command = (false === $this->session->isAuthenticated()) ? 'Authentication' : ucfirst($this->request->getArgument('cmd'));

		\CENSUS\Core\Helper\Utils::newInstance('\\CENSUS\\Core\\Controller\\' . $command . 'Controller', [$this->request, $this]);
	}

	private function initializeModule()
	{
		$command = (false === $this->session->isAuthenticated()) ? 'Authentication' : ucfirst($this->request->getArgument('mod'));

		\CENSUS\Core\Helper\Utils::newInstance('\\CENSUS\\Core\\Module\\' . $command . 'Module', [$this->configuration->getConfig()]);
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
	 * Initialize the logout command
	 */
	public function initializeLogout()
	{
		$this->session->logout();
	}
}
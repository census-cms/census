<?php
namespace CENSUS\Core;

use CENSUS\Core\Controller\CommandController;

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
     * @var \CENSUS\Core\Controller\CommandController
     */
	private $commandController = null;

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

		$this->configuration = new Configuration($this);
		$this->configuration->initializeConfiguration($baseDir);

		$this->fileBase = new FileBase($this->configuration->getConfigByKey('pagetreeRoot'));
		$this->request = new Request($this->configuration->getConfig());

        $this->request->handleRequest();

        echo '<pre>';
        var_dump($this->session);
        echo '</pre>';
	}

	/**
	 * @param \CENSUS\Core\Configuration $classLoader
	 */
	public function setClassLoader($classLoader)
	{
		$this->classLoader = $classLoader;
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
}
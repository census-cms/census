<?php
namespace CENSUS\Core;

class Request
{
    /**
     * @var \CENSUS\Model\Request
     */
    private $request = null;

    /**
     * Requested command
     *
     * @var string|null
     */
    private $command = null;

    /**
     * Requested action
     *
     * @var null
     */
    private $action = null;

	/**
	 * @var \CENSUS\Core\Application
	 */
    private $application = null;

	/**
	 * Configuration array
	 *
	 * @var array
	 */
    private $configuration = [];

	/**
	 * Request constructor
	 *
	 * @param \CENSUS\Core\Application $application
	 * @throws \CENSUS\Core\Exception
	 */
    public function __construct($application)
    {
    	$this->application = $application;
        $this->configuration = $this->application->getConfiguration()->getConfig();

        $this->initializeRequest();
        $this->initializeCommandAndAction();

        $this->handleRequest();
    }

    /**
     * Initializes the request
     */
    private function initializeRequest()
    {
        $this->request = new \CENSUS\Model\Request();

        $this->request->setParams($_GET);
        $this->request->setArguments($_REQUEST);
    }

    /**
     * Initializes the command
     */
    private function initializeCommandAndAction()
    {
        $this->command = ($this->request->hasArgument('cmd')) ? $this->request->getArgument('cmd') : null;
        $this->action = ($this->request->hasArgument('action')) ? $this->request->getArgument('action') : null;
    }

    /**
     * Handles the request
     * and makes an instance of the
     * requested command controller
	 *
	 * @throws \CENSUS\Core\Exception
     */
    private function handleRequest()
    {
		$this->validateRequest();
		$this->setDefaultCommandAndAction();
    }

    private function setDefaultCommandAndAction()
	{
		if (true !== $this->application->getIsAuthenticated()) {
			$this->command = 'authentication';
			$this->action = 'login';
		}

		/*
		 * by default, the dashboard is loaded if no command is set
		 */
		if (null == $this->command) {
			$this->command = 'backend';
		}
	}

	/**
	 * Validate the request
	 *
	 * @throws \CENSUS\Core\Exception
	 * @todo add more validation
	 */
    private function validateRequest()
    {
        if (null !== $this->command) {
            if ($commandWhitelistArray = $this->configuration['cms']['controllerAction']) {
                if (!array_key_exists($this->command, $commandWhitelistArray)) {
                    throw new \CENSUS\Core\Exception('Command ' . $this->command . ' is not allowed', \CENSUS\Core\Exception::ERR_NOT_ALLOWED);
                }
            } else {
                throw new \CENSUS\Core\Exception('Configuration error', \CENSUS\Core\Exception::ERR_ABORT);
            }
        }
    }

    /**
     * Get the request
     *
     * @return \CENSUS\Model\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the current command
     *
     * @return string|null
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Get the current action
     *
     * @return null
     */
    public function getAction()
    {
        return $this->action;
    }
}
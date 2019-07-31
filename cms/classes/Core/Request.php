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
     * User is authenticated
     *
     * @var bool
     */
    private $isAuthenticated = false;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;

        $this->initializeSession();
        $this->initializeRequest();
        $this->initializeCommandAndAction();

        return $this;
    }

    private function initializeSession()
    {
        if (isset($_SESSION['censuscms'])) {
            $this->isAuthenticated = true;
        }
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
     */
    public function handleRequest()
    {
        $this->validateRequest();

        if (false === $this->isAuthenticated) {
            $this->command = 'authentication';
            $this->action = 'login';
        }

        /*
         * by default, the dashboard is loaded if no command is set
         */
        if (null == $this->command) {
            $this->command = 'dashboard';
        }

        $requestedCommandControllerName = ucfirst($this->command) . 'Controller';
        $requestedCommandControllerClass = '\\CENSUS\\Core\\Controller\\' . $requestedCommandControllerName;

        if (class_exists($requestedCommandControllerClass)) {
            new $requestedCommandControllerClass(
                $this->command,
                $this->action,
                $this->configuration,
                $this->request
            );
        }
    }

    private function validateRequest()
    {
        if (null !== $this->command) {
            if ($commandWhitelistArray = $this->configuration['cms']['controllerAction']) {
                if (!array_key_exists($this->command, $commandWhitelistArray)) {
                    throw new \Exception('Command ' . $this->command . ' is not allowed', 1104);
                }
            } else {
                throw new \Exception('Configuration error', 1103);
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
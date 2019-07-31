<?php
namespace CENSUS\Core\Controller;

abstract class CommandController
{
    /**
     * The controller/action configuration context
     *
     * @var string
     */
    protected $context = 'cms';

    /**
     * Requested command
     *
     * @var string|null
     */
    protected $command = null;

    /**
     * Requested action
     *
     * @var null
     */
    protected $action = null;

    /**
     * @var \CENSUS\Model\Request
     */
    protected $request = [];

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var \CENSUS\Core\View
     */
    protected $view = null;

    /**
     * CommandController constructor
     *
     * @param string $command
     * @param string $action
     * @param array $configuration
     * @param array $request
     */
    public function __construct($command, $action, $configuration, $request)
    {
        $this->command = $command;
        $this->action = $action;
        $this->configuration = $configuration;
        $this->request = $request;

        $this->initializeAction();
    }

    /**
     * Initialize action
     */
    private function initializeAction()
    {
        if (null === $this->action) {
            $this->setDefaultAction();
        }

        $this->initializeView();
        $this->callDefaultAction();
    }

    /**
     * Set default action
     *
     * Checks if the current command has a default action while
     * request does not provide one
     */
    private function setDefaultAction()
    {
        $actions = $this->configuration[$this->context]['controllerAction'][$this->command];
        $this->action = (isset($actions[0])) ? $actions[0] : null;
    }

    /**
     * Initialize the view
     */
    private function initializeView()
    {
        $this->view = new \CENSUS\Core\View($this->command);
    }

    /**
     * Call the default action if set
     */
    private function callDefaultAction()
    {
        if (null !== $this->action) {
            $actionMethodName = $this->action . 'Action';
            $this->$actionMethodName();
        }
    }
}
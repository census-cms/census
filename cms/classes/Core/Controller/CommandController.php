<?php
namespace CENSUS\Core\Controller;

/**
 * Class CommandController
 * Extended by any controller, instanciates the view
 * The command controller switches the controller by the given
 * command (cmd) and action (action) from the request.
 *
 * @package CENSUS\Core\Controller
 */
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
    protected $request = null;

	/**
	 * @var \CENSUS\Core\Application
	 */
    private $application = null;

    /**
     * @var \CENSUS\Core\Configuration
     */
    protected $configuration = [];

    /**
     * @var \CENSUS\Core\View
     */
    protected $view = null;

    /**
     * CommandController constructor
     *
     * @param array $request
	 * @param \CENSUS\Core\Application
     */
    public function __construct($request, $application)
    {
        $this->request = $request;
        $this->application = $application;
		$this->configuration = $this->application->getConfiguration()->getConfig();

		$this->command = $this->request->getArgument('cmd');
		$this->action = $this->request->getArgument('action');

		$this->initializeView();
		$this->callDefaultAction();
    }

    /**
     * Initialize the view
     */
    private function initializeView()
    {
        $this->view = new \CENSUS\Core\View($this->request, $this->configuration['view']);
    }

    /**
     * Call the default action if set
     */
    private function callDefaultAction()
    {
		if (method_exists($this, 'initializeAction')) {
			$this->initializeAction();
		}

		$actionMethodName = 'loginAction';

        if (true === $this->request->getArgument('isAuthenticated')) {
			if (null === $this->request->getArgument('action')) {
				$actionMethodName = $this->getDefaultAction() . 'Action';
			} else {
				$actionMethodName = $this->request->getArgument('action') . 'Action';
			}
        }

		$this->$actionMethodName();
    }

	/**
	 * Get default action
	 *
	 * Checks if the current command has a default action while
	 * request does not provide one
	 */
	private function getDefaultAction()
	{
		$actions = $this->configuration[$this->context]['controllerAction'][$this->command];
		return (isset($actions[0])) ? $actions[0] : null;
	}

	/**
	 * Get the application
	 *
	 * @return \CENSUS\Core\Application
	 */
    public function getApplication()
	{
		return $this->application;
	}

	/**
	 * Http redirect
	 *
	 * $location can be a string or an array with params[param1=foo, param2=bar]
	 *
	 * @param array|string $location
	 * @param int $response
	 */
	public function redirect($location, $response = 301)
	{
		if (is_array($location)) {
			$location = '?' . implode('&', $location);
		}

		header('Location: ' . $location, true, $response);
	}
}
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
    protected  $context = 'cms';

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
     * @param \CENSUS\Model\Request $request
	 * @param \CENSUS\Core\View $view
	 * @param \CENSUS\Core\Application
     */
    public function __construct(\CENSUS\Model\Request $request, \CENSUS\Core\View $view, \CENSUS\Core\Application $application)
    {
        $this->request = $request;
        $this->view = $view;
        $this->application = $application;
		$this->configuration = $this->application->getConfiguration()->getConfig();

		$this->command = $this->request->getArgument('cmd');
		$this->action = $this->request->getArgument('action');

		$this->initializeControllerAction();
    }

    /**
     * Initialize the controller => action
     */
    private function initializeControllerAction()
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
        } else {
        	if (!empty($this->request->getParams())) {
				$this->redirect('/backend/');
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
	 * @param int $httpStatus
	 */
	public function redirect(string $location, int $httpStatus = 301)
	{
		if (is_array($location)) {
			$location = '?' . implode('&', $location);
		}

		header('Location: ' . $location, true, $httpStatus);
	}
}
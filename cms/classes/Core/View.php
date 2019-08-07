<?php
namespace CENSUS\Core;

/**
 * Class View
 * The view is a wrapper class which provieds a connection
 * to the view rendered by Twig. It also sets template paths
 * by the requested command and action.
 *
 * @package CENSUS\Core
 */
class View
{
	/**
	 * @var \CENSUS\Model\Request
	 */
	private $request = null;

	/**
	 * View configuration
	 *
	 * @var array
	 */
    private $configuration = [];

	/**
	 * Arguments to feed
	 *
	 * @var array
	 */
    private $arguments = [];

	/**
	 * The layout
	 *
	 *
	 * @var string
	 */
    private $layout = 'backend.html';

    /**
     * Twig
     *
     * @var \Twig\Environment
     */
    private $twig = null;

	/**
	 * View constructor
	 *
	 * @param \CENSUS\Model\Request $request
	 * @param array $configuration
	 */
    public function __construct($request, $configuration)
    {
        $this->configuration = $configuration;
        $this->request = $request;

        $this->initializeView();
    }

	/**
	 * Initialize template
	 */
    private function initializeView()
	{
		$loader = new \Twig\Loader\FilesystemLoader($this->configuration['templatePaths']);
		$this->twig = new \Twig\Environment($loader);
	}

	/**
	 * Get the requested template by action or module
	 *
	 * @return string
	 */
	private function getLayoutByRequest()
	{
		$module = $this->request->getArgument('mod');
		$template = 'controller/' . $this->request->getArgument('cmd') . DIRECTORY_SEPARATOR . $this->request->getArgument('action');

		if (null !== $module) {
			$template = 'module/' . $module;
		}

		return $template . '.html';
	}

	/**
	 * Assign arguments
	 *
	 * @param array $arguments
	 */
	public function assign($arguments)
	{
		$this->arguments = array_merge($this->arguments, $arguments);
	}

	/**
	 * Render the view before class dies
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function __destruct()
	{
		echo $this->twig->render($this->getLayoutByRequest(), $this->arguments);
	}
}
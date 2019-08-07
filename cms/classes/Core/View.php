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
        $this->registerGlobals();
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
	 * Register the global variables for Twig
	 */
	private function registerGlobals()
	{
		$this->twig->addGlobal('CMS__navigation', (new \CENSUS\Core\View\Globals\Navigation())->getArguments());
	}

	/**
	 * Get the requested template by action or module
	 *
	 * @return string
	 */
	public function getLayoutByRequest()
	{
		$module = $this->request->getArgument('mod');
		$template = 'controller/' . $this->request->getArgument('cmd') . DIRECTORY_SEPARATOR . $this->request->getArgument('action');

		if (null !== $module && file_exists(TEMPLATE_DIR . 'module/' . $module . '/index.html')) {
			$template = 'module/' . $module . '/index';
		}

		return $template . '.html';
	}

	/**
	 * @return \Twig\Environment
	 */
	public function getTwig()
	{
		return $this->twig;
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
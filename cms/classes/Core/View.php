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
	 * Layout path
	 *
	 * @var string
	 */
    private $layout = '';

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
        $this->initializeLayout();
        $this->registerGlobals();
    }

	/**
	 * Initialize template
	 */
    private function initializeView()
	{
		$loader = new \Twig\Loader\FilesystemLoader($this->configuration['templatePaths']);
		$this->twig = new \Twig\Environment($loader, ['debug' => $this->configuration['debug']]);

		if (true === $this->configuration['debug']) {
			$this->twig->addExtension(new \Twig\Extension\DebugExtension());
		}
	}

	private function initializeLayout()
	{
		$module = $this->request->getArgument('mod');
		$context = $this->request->getArgument('context');

		$layout = 'controller/' . $this->request->getArgument('cmd') . DIRECTORY_SEPARATOR . $this->request->getArgument('action');

		if (true === $this->request->getArgument('isAuthenticated')) {
			if (null !== $module && file_exists(TEMPLATE_DIR . 'module/' . $module . '/index.html')) {
				$layout = 'module/' . $module . '/index';
			}

			if (null !== $context && file_exists(TEMPLATE_DIR . 'module/' . $module . '/' . $context .  '.html')) {
				$layout = 'module/' . $module . '/' . $context;
			}
		}

		$this->setLayout($layout);
	}

	/**
	 * Register the global variables for Twig
	 */
	private function registerGlobals()
	{
		$this->twig->addGlobal('GLOBAL__navigation', (new \CENSUS\Core\View\Globals\Navigation())->getArguments());
	}

	/**
	 * Get the layout
	 *
	 * @return string
	 */
	public function getLayout()
	{
		return $this->layout . '.html';
	}

	/**
	 * Set the layout
	 *
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
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
		echo $this->twig->render($this->getLayout(), $this->arguments);
	}
}
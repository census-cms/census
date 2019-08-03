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
     * The requested command
     *
     * @var string
     */
    private $command;

	/**
	 * The requested action
	 *
	 * @var string
	 */
    private $action = '';

	/**
	 * View configuration
	 *
	 * @var array
	 */
    private $configuration = [];

	/**
	 * Arguments to include
	 *
	 * @var array
	 */
    private $arguments = [];

	/**
	 * Template file
	 *
	 * @var string
	 */
    private $templateFile = '';

	/**
	 * @var \CENSUS\Core\View\Resources
	 */
    private $resources = null;

    /**
     * Twig
     *
     * @var \Twig\Environment
     */
    private $twig = null;

	/**
	 * View constructor
	 *
	 * @param string $command
	 * @param string $action
	 * @param array $viewConfig
	 */
    public function __construct($command, $action, $viewConfig)
    {
        $this->command = $command;
        $this->action = $action;
        $this->configuration = $viewConfig['template'];
        $this->resources = new \CENSUS\Core\View\Resources($viewConfig['resources']);

        $this->initializeTemplate();

        $loader = new \Twig\Loader\FilesystemLoader($this->getTemplatePaths());
        $this->twig = new \Twig\Environment($loader);
    }

	/**
	 * Initialize template
	 */
    private function initializeTemplate()
	{
		$this->templateFile = $this->action . '.html';
	}

	/**
	 * Assign arguments to the view
	 *
	 * @param array $arguments
	 */
    public function assign($arguments)
	{
		$this->arguments = $arguments;
	}

	/**
	 * Render
	 * A wrapper for the Twig renderer
	 *
	 * @param string $layout
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
    public function render($layout = '_layout.html')
    {
        echo $this->twig->render($layout, ['page' => $this->getPageParts()]);
    }

	/**
	 * Get the HTML parts for the template
	 *
	 * @return array
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
    private function getPageParts()
	{
		return [
			'resources' => $this->resources->getPageResources(),
			'body' => $this->twig->load($this->templateFile)->render($this->arguments)
		];
	}

	/**
	 * Get the template paths
	 *
	 * @return array
	 */
    private function getTemplatePaths()
	{
		$paths = [
			$this->getControllerTemplatePath()
		];

		if (!empty($this->configuration['paths'])) {
			$paths = array_merge($paths, $this->configuration['paths']);
		}

		return $paths;
	}

	/**
	 * Get the default template path for controller
	 */
    private function getControllerTemplatePath()
	{
		return TEMPLATE_DIR . 'controller/' . strtolower($this->command);
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
		$this->render();
	}
}
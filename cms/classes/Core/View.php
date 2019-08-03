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
	 * The layout
	 *
	 *
	 * @var string
	 */
    private $layout = '_layout.html';

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
	 * @var \CENSUS\Core\View\Navigation
	 */
    private $navigation = null;

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

        $this->resources = new \CENSUS\Core\View\Resources($command, $viewConfig['resources']);
        $this->navigation = new \CENSUS\Core\View\Navigation();

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
		foreach ($arguments as $key => $argument) {
			if (is_array($argument)) {
				foreach ($argument as $argumentKey => $argumentSub) {
					$this->arguments[$argumentKey] = $argumentSub;
				}
			} else {
				$this->arguments[$key] = $argument;
			}
		}
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
	 * Render
	 * A wrapper for the Twig renderer
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
    public function render()
    {
        echo $this->twig->render($this->layout, ['page' => $this->getPageParts()]);
    }

	/**
	 * Render a partial into an existing view
	 *
	 * @param string $fileName
	 * @param array $arguments
	 *
	 * @return string
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
    private function getPartial($fileName, $arguments)
	{
		return $this->twig->render($fileName, $arguments);
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
			'navigation' => $this->getPartial(
				'partials/navigation.html', array_merge($this->arguments,
				['nav' => $this->navigation->getList()])
			),
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
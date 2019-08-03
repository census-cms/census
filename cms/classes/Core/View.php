<?php
namespace CENSUS\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    /**
     * The requested command
     *
     * @var string
     */
    private $command;

	/**
	 * The template path
	 *
	 * @var string
	 */
    private $templatePath = '';

    /**
     * Twig
     *
     * @var \Twig\Environment
     */
    private $twig = null;

    public function __construct($command)
    {
        $this->command = $command;

        $this->setControllerTemplatePath();

        $loader = new FilesystemLoader($this->getTemplatePath());
        $this->twig = new Environment($loader);
    }

	/**
	 * @param string $templateFile
	 * @param array $arguments
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
    public function render($templateFile, $arguments = [])
    {
        echo $this->twig->render($templateFile, $arguments);
    }

	/**
	 * Set the default template path for controller
	 */
    private function setControllerTemplatePath()
	{
		$this->setTemplatePath('controller/' . strtolower($this->command));
	}

	/**
	 * Set the current template path
	 *
	 * @param string $path
	 */
    public function setTemplatePath($path)
	{
		$this->templatePath = TEMPLATE_DIR. $path;
	}

    /**
     * Get the current template path
     */
    public function getTemplatePath()
    {
    	return $this->templatePath;
    }
}
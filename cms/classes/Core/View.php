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
     * Twig
     *
     * @var \Twig\Environment
     */
    private $twig = null;

    public function __construct($command)
    {
        $this->command = $command;

        $loader = new FilesystemLoader($this->getTemplatePath());
        $this->twig = new Environment($loader);
    }

    /**
     * @param string $templateFile
     * @param array $arguments
     */
    public function render($templateFile, $arguments = [])
    {
        echo $this->twig->render($templateFile, $arguments);
    }

    /**
     * Set the current template
     */
    private function getTemplatePath()
    {
        $systemTemplateDir = strtolower($this->command);
        $templatePath = TEMPLATE_DIR . $systemTemplateDir;

        return $templatePath;
    }
}
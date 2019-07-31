<?php
namespace CENSUS\Core;

class Plugin
{
    /**
     * @var \CENSUS\Core\Plugin\Registry
     */
    private $registry = null;

    /**
     * Plugin constructor
     */
    public function __construct()
    {
        $this->initializeRegistry();
        $this->initializePlugins();
    }

    /**
     * Initialize the plugin registry
     */
    private function initializeRegistry()
    {
        $this->registry = new \CENSUS\Core\Plugin\Registry();
    }

    /**
     * Initialize registered plugins
     */
    private function initializePlugins()
    {

    }
}
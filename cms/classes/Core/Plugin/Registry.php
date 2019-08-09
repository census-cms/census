<?php
namespace CENSUS\Core\Plugin;


class Registry
{
    /**
     * @var array
     */
    private $registeredPlugins = [];

    /**
     * Registry constructor
     */
    public function __construct()
    {
        $this->loadRegistry();
    }

    /**
     * Set the registered plugins
     */
    private function loadRegistry()
    {
        $registeredPluginsFile = STORAGE_DIR . 'plugins.yaml';

        if (file_exists($registeredPluginsFile)) {
            $this->registeredPlugins = include $registeredPluginsFile;
        }
    }

    /**
     * @return array
     */
    public function getRegisteredPlugins()
    {
        return $this->registeredPlugins;
    }
}
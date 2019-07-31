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
        $this->setRegisteredPlugins();
    }

    /**
     * Set the registered plugins
     */
    private function setRegisteredPlugins()
    {
        $registeredPluginsFile = STORAGE_DIR . 'plugins.php';

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
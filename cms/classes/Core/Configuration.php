<?php
/**
 * Configuration
 *
 * author: Marc Scherer
 * package: census CMS
 */

namespace CENSUS\Core;

class Configuration
{
	/**
	 * @var string
	 */
	private $configFile = '';

	/**
	 * @var \CENSUS\Core\Application
	 */
	private $application = null;

	/**
	 * The configuration array
	 *
	 * @var array
	 */
	private $configArray = [];

	/**
	 * Configuration constructor
	 *
	 * @param \CENSUS\Core\Application $application
	 */
	public function __construct(\CENSUS\Core\Application $application)
	{
		$this->configFile = __DIR__ . '/../../settings/Configuration.php';
		$this->application = $application;
	}

	/**
	 * Initialize the config
	 */
	public function initializeConfiguration()
	{
		$this->configArray = include $this->configFile;

		$this->mergeUserConfiguration();
	}

    /**
     * Merge custom into default configuration
     */
	private function mergeUserConfiguration()
    {
        $userConfigurationFile = BASE_DIR . '/config.php';

        if (file_exists($userConfigurationFile)) {
            $userConfiguration = include $userConfigurationFile;
            $this->configArray = array_merge($this->configArray, $userConfiguration);
        }
    }

	/**
	 * Get parts of the configuration array
	 *
	 * @param string $key
	 * @return array|string|false
	 */
	public function getConfigByKey(string $key)
	{
		return (array_key_exists($key, $this->configArray)) ? $this->configArray[$key] : false;
	}

    /**
     * Get the configuration array
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->configArray;
    }
}
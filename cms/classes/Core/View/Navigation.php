<?php
namespace CENSUS\Core\View;

/**
 * Class Resources
 * Can return page resources as HTML tags from the configuration into the view
 *
 * @package CENSUS\Core\View
 */
class Navigation
{
	/**
	 * The module configuration
	 *
	 * @var array
	 */
	private $moduleConfig = [];

	/**
	 * Resources constructor
	 */
	public function __construct ()
	{
		$this->initializeNavigation();
	}

	/**
	 * Initialize the navigation
	 */
	private function initializeNavigation()
	{
		$configFile = __DIR__ . '/../../../settings/Modules.php';

		$this->moduleConfig = include $configFile;
	}

	/**
	 * Get the category navigation list array
	 *
	 * @return array
	 */
	public function getList()
	{
		$navigation = [
			'categories' => [],
		];

		foreach ($this->moduleConfig as $key => $category) {
			$navigation['categories'][] = [
				'label' => ucfirst($key),
				'modules' => $this->getModuleNav($key, $category)
			];
		}

		return $navigation;
	}

	/**
	 * Get the category modules
	 *
	 * @param string $category
	 * @param array $entries
	 * @return array
	 */
	private function getModuleNav($category, $entries)
	{
		$moduleLinks = [];

		foreach ($entries as $key => $module) {
			$moduleLinks[] = [
				'key' => $key,
				'href' => (isset($module['href'])) ? $module['href'] : '?cmd=backend&action=module&mod=' . $key,
				'label' => $module['label'],
				'category' => ucfirst($category)
			];
		}

		return $moduleLinks;
	}
}
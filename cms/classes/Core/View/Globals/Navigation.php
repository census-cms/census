<?php
namespace CENSUS\Core\View\Globals;

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
	 * Initialize the navigation
	 */
	public function __construct()
	{
		$this->moduleConfig = include CONFIG_DIR . 'Modules.php';
	}

	/**
	 * Get the category navigation list array
	 *
	 * @return array
	 */
	public function getArguments()
	{
		$navigation = [];

		foreach ($this->moduleConfig as $key => $category) {
			$navigation[] = [
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
	private function getModuleNav(string $category, array $entries)
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
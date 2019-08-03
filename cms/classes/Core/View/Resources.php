<?php
namespace CENSUS\Core\View;

/**
 * Class Resources
 * Can return page resources as HTML tags from the configuration into the view
 *
 * @package CENSUS\Core\View
 */
class Resources
{
	/**
	 * Page resources
	 *
	 * @var string
	 */
	private $resources = '';

	/**
	 * Resources constructor
	 *
	 * @param array $resources
	 */
	public function __construct ($resources)
	{
		$this->resources = $resources;
	}

	/**
	 * Get the page resources
	 *
	 * @return string
	 */
	public function getPageResources()
	{
		if (!empty($this->resources)) {
			return $this->render();
		}
	}

	/**
	 * Render the existing resources from config
	 *
	 * @return string
	 */
	private function render()
	{
		$resources = '';

		foreach ($this->resources as $key => $resource) {
			switch($key) {
				case 'css':
					$resources .= $this->getStylesheetTag($resource);
					break;
				case 'js':
					$resources .= $this->getJavascriptTag($resource);
					break;
			}
		}

		return $resources;
	}

	/**
	 * Get a stylsheet tag
	 *
	 * @param string|array $stylesheet
	 * @return string
	 */
	private function getStylesheetTag($stylesheet)
	{
		$href = (is_array($stylesheet)) ? array_pop($stylesheet) : $stylesheet;
		return '<link rel="stylesheet" type="text/css" href="' . $href . '">' . PHP_EOL;
	}

	/**
	 * Get a javascript tag
	 *
	 * @param string|array $javascript
	 * @return string
	 */
	private function getJavascriptTag($javascript)
	{
		$src = (is_array($javascript)) ? array_pop($javascript) : $javascript;
		return '<script src="' . $src . '"></script>' . PHP_EOL;
	}
}
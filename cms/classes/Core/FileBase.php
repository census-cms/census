<?php
namespace CENSUS\Core;

/**
 * FileBase
 *
 * The FileBase is the magic in census CMS, it manages the operations
 * between the application and the content files which are building the
 * whole content.
 *
 * author: Marc Scherer
 * package: census CMS core
 */

class FileBase
{
	/**
	 * The current selected page
	 *
	 * @var string
	 */
	private $currentPagePath = '';

	/**
	 * The flatten page tree
	 *
	 * @var array
	 */
	private $pageTree = [];

	/**
	 * @var array
	 */
	private $pageMeta = [];

	/**
	 * A collection of all contents for this path
	 *
	 * @var array
	 */
	private $pageContent = [];

	/**
	 * FileBase constructor
	 *
	 * @param string $basePath
	 * @throws Exception
	 */
	public function __construct(string $basePath)
	{
		$this->currentPagePath = BASE_DIR . DIRECTORY_SEPARATOR . $basePath;

		$this->_validatePagePath();

		// migrate methods into separated objects
		$this->_loadPageTreeConfig();
		$this->_loadPageMeta();
		$this->_loadPageContent();
	}

	/**
	 * Validate the current path by matching some restrictions
	 *
	 * @throws \CENSUS\Core\Exception
	 */
	private function _validatePagePath()
	{
		if (!is_dir($this->currentPagePath)) {
			throw new \CENSUS\Core\Exception('Page ('. $this->currentPagePath .') does not exist.', \CENSUS\Core\Exception::ERR_NOT_FOUND);
		}

		// @todo do some more validation about: meta exists? content exists?
	}

	/**
	 * Load a config array from file
	 *
	 * @param string $file
	 * @return array
	 */
	protected static function loadConfigFromFile(string $file)
	{
		return (file_exists($file)) ? include $file : [];
	}




	// split into page tree class
	private function _loadPageTreeConfig()
	{
		$file = BASE_DIR . '/page/tree.php';
		$this->pageTree = self::loadConfigFromFile($file);
	}

	private function _writePageTreeConfig()
	{

	}

	protected function updatePageTreeConfig()
	{
		if (1 == 2) {
			$this->_writePageTreeConfig();
		}
	}


	// split into page meta class
	private function _loadPageMeta()
	{
		$file = $this->currentPagePath . 'meta.php';
		$this->pageMeta = self::loadConfigFromFile($file);
	}

	private function _writePageMeta()
	{

	}

	protected function updatePageMeta()
	{
		if (1 == 2) {
			$this->_writePageMeta();
		}
	}



	// split into page content class
	private function _loadPageContent()
	{
		$this->pageContent = glob($this->currentPagePath . '*.census');
	}

	private function _writePageContent()
	{

	}

	protected function updatePageContent()
	{
		if (1 == 2) {
			$this->_writePageContent();
		}
	}
}
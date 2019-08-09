<?php
namespace CENSUS\Core\Module;

/**
 * Class Page
 * This is the page module. It handles all requested context methods
 * to manage pages.
 *
 * @package CENSUS\Core\Module
 */
class Page extends AbstractModule
{
	/**
	 * Page repository
	 *
	 * @var \CENSUS\Core\Repository\PageRepository
	 */
	private $pageRepository = null;

	/**
	 * Contains information if a page in the tree is selected
	 *
	 * @var array
	 */
	private $selectedPage = [];

	/**
	 * Initialize the module
	 */
	protected function initializeModule()
	{
		$this->pageRepository = new \CENSUS\Core\Repository\PageRepository($this->configuration['pagetreeRoot']);

		$this->view->assign(
			[
				'pagetree' => $this->pageRepository->getTree(),
				'currentDir' => $this->request->getArgument('dir')
			]
		);
	}

	/**
	 * Index context
	 * Lists the page tree
	 */
	protected function indexContext()
	{

	}

	protected function contentContext()
	{
		$this->view->assign(
			[
				'pageData' => $this->getPageData()
			]
		);
	}

	/**
	 * Edit context
	 * Edits existing pages
	 */
	protected function editContext()
	{
		$this->view->assign(
			[
				'pageData' => $this->getPageData()
			]
		);
	}

	/**
	 * Add context
	 * Adds new pages
	 */
	protected function addContext()
	{
	}




	/**
	 * Get current page data
	 *
	 * @return array|null
	 */
	private function getPageData()
	{
		$pagePath = $this->getPagePath();
		return $this->pageRepository->getData($pagePath);
	}

	/**
	 * Get the current page path in page tree
	 *
	 * @return string
	 */
	private function getPagePath()
	{
		$parent = (null !== $this->request->getArgument('parent')) ? urldecode($this->request->getArgument('parent')) : '';
		$dir = $this->request->getArgument('dir');

		return realpath(BASE_DIR . 'page/' . $parent . DIRECTORY_SEPARATOR . $dir) . DIRECTORY_SEPARATOR;
	}
}
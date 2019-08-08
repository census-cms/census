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

	/**
	 * Add context
	 * Adds new pages
	 */
	protected function addContext()
	{
	}

	/**
	 * Edit context
	 * Edits existing pages
	 */
	protected function editContext()
	{
		$pagePath = $this->getPagePath();

		$pageData = $this->pageRepository->getData($pagePath);

		// @todo add content data

		$this->view->assign(
			[
				'pageData' => $pageData
			]
		);
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
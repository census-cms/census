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
	}
}
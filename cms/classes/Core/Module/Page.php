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
	 * Content repository
	 *
	 * @var \CENSUS\Core\Repository\ContentRepository
	 */
	private $contentRepository = null;

	/**
	 * The current page path selected in tree
	 *
	 * @var string
	 */
	private $currentPath = '';

	/**
	 * Initialize the module
	 */
	protected function initializeModule()
	{
		$this->pageRepository = new \CENSUS\Core\Repository\PageRepository($this->configuration['pagetreeRoot']);
		$this->contentRepository = new \CENSUS\Core\Repository\ContentRepository();

		$this->currentPath = $this->pageRepository->getPagePath($this->request->getArgument('parent'), $this->request->getArgument('dir'));

		$this->view->assign(
			[
				'pagetree' => $this->pageRepository->getPageTree(),
				'currentDir' => $this->request->getArgument('dir')
			]
		);
	}

	/**
	 * Index context
	 * Lists the page tree and content
	 */
	protected function indexContext()
	{
		$this->view->assign(
			[
				'pageData' => $this->pageRepository->getPageData($this->currentPath),
				'contentData' => $this->contentRepository->getPreview($this->currentPath)
			]
		);
	}

	protected function contentContext()
	{
		$type = $this->request->getArgument('type');
		$index = $this->request->getArgument('index');

		$this->view->assign(
			[
				'contentData' => $this->contentRepository->getContent($this->currentPath, $type, $index)
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
				'pageData' => $this->pageRepository->getPageData($this->currentPath)
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
}
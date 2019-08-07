<?php
namespace CENSUS\Core\Module;


class PageModule extends AbstractModule
{
	/**
	 * Page repository
	 *
	 * @var \CENSUS\Core\Repository\PageRepository
	 */
	private $pageRepository = null;

	protected function initializeModule()
	{
		$this->pageRepository = new \CENSUS\Core\Repository\PageRepository($this->configuration['pagetreeRoot']);
	}

	protected function renderPagetree()
	{

	}
}
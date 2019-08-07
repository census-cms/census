<?php
namespace CENSUS\Core\Controller;

/**
 * Class BackendController
 * Provides the access to each module, manages settings
 * and connects the plugins to the backend.
 *
 * @package CENSUS\Core\Controller
 */
class BackendController extends CommandController
{
	private $backend = null;

	protected function initializeAction()
	{
		$this->backend = new \CENSUS\Core\Backend($this->getApplication());

		$currentModule = $this->request->hasArgument('mod') ? $this->request->getArgument('mod') : '';

		$this->view->assign(
			[
				'currentModule' => $currentModule
			]
		);
	}

	protected function dashboardAction()
	{
		$this->view->assign(['dddd' => 'eeee']);
	}

	protected function moduleAction()
	{
		$this->view->assign(['foo' => 'bar']);
	}
}
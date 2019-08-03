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
	}

	protected function dashboardAction()
	{
	}

	protected function moduleAction()
	{
	}
}
<?php
namespace CENSUS\Core\Form;


class Handler
{
	/**
	 * @var \CENSUS\Model\Request
	 */
	private $request = null;

	public function __construct ($request)
	{
		$this->request = $request;

		$this->initializeHandlerByRequest();
	}

	private function initializeHandlerByRequest()
	{

	}
}
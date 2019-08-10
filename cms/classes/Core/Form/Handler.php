<?php
namespace CENSUS\Core\Form;


class Handler
{
	/**
	 * @var \CENSUS\Model\Request
	 */
	private $request = null;

	/**
	 * Used namespace for field names
	 *
	 * @var string
	 */
	private $namespace = '';

	/**
	 * Content of $_POST data
	 *
	 * @var array
	 */
	private $data = [];

	public function __construct ($request)
	{
		$this->request = $request;

		$this->setNamespace();
		$this->setPostData();
		$this->initializeHandlerByRequest();
	}

	/**
	 * Set the namspace used in $_POST
	 *
	 * @throws \CENSUS\Core\Exception
	 */
	private function setNamespace()
	{
		$postKeys = array_keys($_POST);

		if (count($postKeys) > 1 && !isset($_POST['auth'])) {
			throw new \CENSUS\Core\Exception('Mixed form data in field names, form must contain only one namespace', \CENSUS\Core\Exception::ERR_INVALID);
		}

		$this->namespace = $postKeys[0];
	}

	/**
	 * Set the post data
	 */
	private function setPostData()
	{
		$this->data = $_POST[$this->namespace];
	}

	/**
	 * Initialize the form handler by request
	 */
	private function initializeHandlerByRequest()
	{
		$formHandlerClassName = '\\CENSUS\\Core\\Form\\Handler\\' . ucfirst($this->namespace);

		if (class_exists($formHandlerClassName)) {
			\CENSUS\Core\Helper\Utils::newInstance($formHandlerClassName, [$this]);
		}
	}

	/**
	 * Persist data
	 *
	 * @param string $file
	 * @param mixed $data
	 */
	public function persist($file, $data)
	{
		$fh = fopen($file, 'w');
		fwrite($fh, $data);
		fclose($fh);
	}

	/**
	 * Get the request
	 *
	 * @return \CENSUS\Model\Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Get the $_POST data
	 *
	 * @return array
	 */
	public function getPostData()
	{
		return $this->data;
	}
}
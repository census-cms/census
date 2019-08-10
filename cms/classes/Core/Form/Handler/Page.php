<?php
namespace CENSUS\Core\Form\Handler;

/**
 * Class Page
 * Handles the form data for pages (add/save, edit/save).
 *
 * @package CENSUS\Core\Form\Handler
 */
class Page
{
	/**
	 * @var \CENSUS\Core\Form\Handler
	 */
	private $handler = null;

	/**
	 * Initialize form page handler
	 *
	 * @param  $handler
	 */
	public function __construct(\CENSUS\Core\Form\Handler $handler)
	{
		$this->handler = $handler;

		$this->persist();
	}

	/**
	 * Persist the form data for page meta
	 */
	private function persist()
	{
		$file = $this->getPagePath() . '/meta.yaml';
		$this->handler->persist($file, $this->getYamlString());
	}

	/**
	 * Get the current page path
	 *
	 * @return bool|string
	 */
	private function getPagePath()
	{
		$request = $this->handler->getRequest();
		return realpath(PAGE_DIR . $request->getArgument('parent') . DIRECTORY_SEPARATOR . $request->getArgument('dir'));
	}

	/**
	 * Get YAML
	 *
	 * @return string
	 */
	private function getYamlString()
	{
		return \CENSUS\Core\Helper\Yaml::dump($this->getMetaArray());
	}

	/**
	 * Get the meta file array
	 *
	 * @return array
	 */
	private function getMetaArray()
	{
		$data = $this->handler->getPostData();

		$metaArray = [
			'dir' => $this->handler->getRequest()->getArgument('dir'),
			'parent' => $this->handler->getRequest()->getArgument('parent'),
			'realname' => $data['realname'],
			'description' => $data['description']
		];

		if ($data['root']) {
			$metaArray['root'] = 'true';
		}

		return $metaArray;
	}
}
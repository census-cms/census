<?php
namespace CENSUS\Core\Repository;


class PageRepository extends AbstractRepository
{
	private $pagetree = [];

	/**
	 * Initialize the repository
	 */
	public function initializeRepository()
	{
		$this->pagetree = $this->getTree();
	}

	/**
	 * Get the page tree
	 *
	 * @return mixed
	 */
	public function getTree()
	{
		$json = file_get_contents(BASE_DIR . $this->getStorage() . '/tree.json');
		$tree = \CENSUS\Core\Helper\Utils::getJsonToArray($json);

		return $tree;
	}

	/**
	 * Get data from a page
	 *
	 * @param string $path
	 * @return null|array
	 */
	public function getData(string $path)
	{
		$file = $path . 'meta.yaml';
		$data = null;

		if (file_exists($file)) {
			$data = \CENSUS\Core\Helper\Yaml::parseFile($file);
		}

		return $data;
	}
}
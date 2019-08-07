<?php
namespace CENSUS\Core\Repository;


class PageRepository extends AbstractRepository
{
	private $pagetree = [];

	public function getPagetree()
	{

	}

	public function initializeRepository()
	{
		$this->initializePagetree();
	}

	private function initializePagetree()
	{
		$this->pagetree = $this->getTree();

		var_dump($this->pagetree);
	}

	private function getTree()
	{
		$tree = include BASE_DIR . $this->getStorage() . '/tree.php';
		return $tree;
	}

	private function buildTree($directory, &$tree = [])
	{
		foreach (scandir($directory) as $content) {
			if (is_dir($content)) {
				$tree[] = $content;

				$subDir = $directory . DIRECTORY_SEPARATOR . $content;

				if (is_dir($subDir)) {

				}
			}
		}

		var_dump($tree);
	}
}
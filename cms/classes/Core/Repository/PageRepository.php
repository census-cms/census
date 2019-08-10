<?php
namespace CENSUS\Core\Repository;


class PageRepository extends AbstractRepository
{
	/**
	 * Get the page tree
	 *
	 * @param string $dir
	 * @param array $tree
	 * @return array
	 */
	public function getPageTree(string $dir = PAGE_DIR, $tree = [])
	{
		foreach (scandir(realpath($dir)) as $entry) {
			if ($entry != '.' && $entry != '..' && $entry != '.content') {
				$path = realpath($dir) . DIRECTORY_SEPARATOR . $entry;

				if (is_dir($path)) {
					$metaFile = $path . DIRECTORY_SEPARATOR . 'meta.yaml';
					$meta = (file_exists($metaFile)) ? $this->getPageMetaFromYaml($metaFile) : null;
					$sub = $this->getPageTree($path);

					$tree[$entry] = [
						'dir' => $entry
					];

					if (null !== $meta) {
						$tree[$entry]['realname'] = $meta['realname'];
						$tree[$entry]['parent'] = $meta['parent'];
					}

					if (isset($meta['root'])) {
						$tree[$entry]['root'] = true;
					}

					if (!empty($sub)) {
						$tree[$entry]['_sub'] = $sub;
					}
				}
			}
		}

		return $tree;
	}

	/**
	 * Get current page data
	 *
	 * @param string $path
	 * @return array
	 */
	public function getPageData(string $path)
	{
		return (!empty($path)) ? $this->getPageMetaFromYaml($path . 'meta.yaml') : [];
	}

	/**
	 * Get the current page path in page tree
	 *
	 * @param string $parent
	 * @param string $dir
	 * @return string
	 */
	public function getPagePath($parent, $dir)
	{
		$parent = (null !== $parent) ? urldecode($parent) : '';
		$dir = (null !== $dir) ? $dir : '';

		return realpath(BASE_DIR . 'page/' . $parent . DIRECTORY_SEPARATOR . $dir) . DIRECTORY_SEPARATOR;
	}

	/**
	 * Get page meta file to array
	 *
	 * @param string $file
	 * @return array
	 */
	public function getPageMetaFromYaml(string $file)
	{
		if (file_exists($file)) {
			return \CENSUS\Core\Helper\Yaml::parseFile($file);
		}

		return null;
	}
}
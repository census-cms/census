<?php
namespace CENSUS\Core\Repository;


class ContentRepository extends AbstractRepository
{
	public function getPreview($path)
	{
		$contentIndexFile = $path . 'content.yaml';
		$previewContent = [];

		if (file_exists($contentIndexFile)) {
			$previewContent = \CENSUS\Core\Helper\Yaml::parseFile($contentIndexFile);
		}

		return $previewContent;
	}
}
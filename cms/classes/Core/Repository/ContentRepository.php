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

	public function getContent($path, $type, $index)
	{
		$contentIndexFile = $path . 'content.yaml';
		$contentIndex = \CENSUS\Core\Helper\Yaml::parseFile($contentIndexFile);
		$selectedContent = $contentIndex[$index];

		$htmlContentFile = $path . '.content/' . $selectedContent['content'];
		$selectedContent['html'] = file_get_contents($htmlContentFile);

		return $selectedContent;
	}
}
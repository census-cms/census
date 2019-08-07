<?php
namespace CENSUS\Core\Repository;

/**
 * AbstractRepository
 *
 * author: Marc Scherer
 * package: census CMS
 */

abstract class AbstractRepository
{
	/**
	 * @var \CENSUS\Core\Model\AbstractModel;
	 */
	private $model = null;

	/**
	 * @var string
	 */
	private $storage = '';

	public function __construct ($storage = STORAGE_DIR)
	{
		$this->storage = $storage;

		$this->initializeModel();

		if (method_exists($this, 'initializeRepository')) {
			$this->initializeRepository();
		}
	}

	private function initializeModel()
	{
		$splitNamespace = explode('\\', get_called_class());
		$repositoryName = str_replace('Repository', '', array_pop($splitNamespace));
		$modelClassName = 'CENSUS\\Model\\' . $repositoryName;

		if (class_exists($modelClassName)) {
			$this->model = new $modelClassName();
		}
	}

	protected function getStorage()
	{
		return $this->storage;
	}
}
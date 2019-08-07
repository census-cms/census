<?php
/**
 * AbstractModel.php
 *
 * author: mas
 */

namespace CENSUS\Model;

abstract class AbstractModel
{
	/**
	 * Identifier
	 *
	 * @var string
	 */
	private $identifier = '';

	/**
	 * Path
	 *
	 * @var string
	 */
	private $path = '';

	/**
	 * Set the identifier
	 *
	 * @param string $identifier
	 * @return AbstractModel
	 */
	protected function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 * Get the identifier
	 *
	 * @return string
	 */
	protected function getIdentifier()
	{
		return $this->identifier;
	}

	/**
	 * Set the path
	 *
	 * @param string $path
	 * @return AbstractModel
	 */
	protected function setPath($path)
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * Get the path
	 *
	 * @return string
	 */
	protected function getPath()
	{
		return $this->path;
	}

	/**
	 * AbstractModel constructor
	 *
	 * @param string $file
	 */
	public function __construct($file = '')
	{
		if (!empty($file)) {
			preg_match_all('/\[.*\]/', basename($file), $fileBaseInfo);

			$this->setIdentifier($fileBaseInfo[2]);
			$this->setPath(dirname($file));
		}
	}
}
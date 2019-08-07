<?php
namespace CENSUS\Model;


class Request
{
    /**
     * Request parameters
     *
     * @var array
     */
    private $params = [];

    /**
     * Request arguments
     *
     * @var array
     */
    private $arguments = [];

    /**
     * Set the parameters
     *
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Get the request parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set the arguments
     *
     * @param array $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Get the request arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Check if argument exists
     *
     * @param string $argument
     * @return bool
     */
    public function hasArgument($argument)
    {
        return isset($this->arguments[$argument]);
    }

    /**
     * Get a requests argument
     *
     * @param $argument
     * @return mixed|null
     */
    public function getArgument($argument)
    {
        return ($this->hasArgument($argument)) ? $this->arguments[$argument] : null;
    }

	/**
	 * @param array $arguments
	 */
    public function set($arguments)
	{
		foreach ($arguments as $argument => $value) {
			$this->arguments[$argument] = $value;
		}
	}
}
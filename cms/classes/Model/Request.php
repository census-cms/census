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
    public function setParams(array $params)
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
    public function setArguments(array $arguments)
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
    public function hasArgument(string $argument)
    {
        return isset($this->arguments[$argument]);
    }

    /**
     * Get a requests argument
     *
     * @param string $argument
     * @return mixed|null
     */
    public function getArgument(string $argument)
    {
        return ($this->hasArgument($argument)) ? $this->arguments[$argument] : null;
    }

	/**
	 * @param array $arguments
	 */
    public function set(array $arguments)
	{
		foreach ($arguments as $argument => $value) {
			$this->arguments[$argument] = $value;
		}
	}
}
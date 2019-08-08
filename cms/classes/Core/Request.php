<?php
namespace CENSUS\Core;

class Request
{
    /**
     * @var \CENSUS\Model\Request
     */
    private $request = null;

	/**
	 * Configuration array
	 *
	 * @var array
	 */
    private $configuration = [];

	/**
	 * Request constructor
	 *
	 * @param \CENSUS\Core\Configuration $configuration
	 * @param bool $isAuthenticated
	 * @throws \CENSUS\Core\Exception
	 */
    public function __construct($configuration, $isAuthenticated)
    {
        $this->configuration = $configuration;

        $this->initializeRequest($isAuthenticated);
		$this->validateRequest();
        $this->initializeCommandAndAction();
    }

    /**
     * Initializes the request
	 *
	 * @param bool $isAuthenticated
     */
    private function initializeRequest($isAuthenticated)
    {
        $this->request = new \CENSUS\Model\Request();

        $this->request->setParams($_GET);
        $this->request->setArguments($_REQUEST);

		$this->request->set(['isAuthenticated' => $isAuthenticated]);
    }

	/**
	 * Validate the request
	 *
	 * @throws \CENSUS\Core\Exception
	 * @todo add more validation
	 */
	private function validateRequest()
	{
		$command = $this->request->getArgument('cmd');

		if (null !== $command) {
			if ($commandWhitelistArray = $this->configuration['cms']['controllerAction']) {
				if (!array_key_exists($command, $commandWhitelistArray)) {
					throw new \CENSUS\Core\Exception('Command ' . $command . ' is not allowed', \CENSUS\Core\Exception::ERR_NOT_ALLOWED);
				}
			} else {
				throw new \CENSUS\Core\Exception('Configuration error', \CENSUS\Core\Exception::ERR_ABORT);
			}
		}
	}

    /**
     * Initializes the command
     */
    private function initializeCommandAndAction()
    {
		if (false === $this->request->getArgument('isAuthenticated')) {
			$this->request->set(
				[
					'cmd' => 'authentication',
					'action' => 'login'
				]
			);
		} else {
			if (null == $this->request->getArgument('cmd')) {
				$this->request->set(
					[
						'cmd' => 'backend',
						'action' => 'dashboard'
					]
				);
			}
		}
    }

    /**
     * Get the request
     *
     * @return \CENSUS\Model\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
<?php
namespace CENSUS\Core;

/**
 * Class Authentication
 *
 * @package CENSUS\Core
 */
class Authentication
{
    private $userDir = BASE_DIR . 'storage/userdata/user/';

    /**
     * @var \CENSUS\Model\Request
     */
    private $request = null;

	/**
	 * Login time (timestamp)
	 *
	 * @var int
	 */
    private $loginTime = 0;

    /**
     * Authentication failed
     *
     * @var bool
     */
    private $isValid = false;

    /**
     * Error
     *
     * @var array
     */
    private $errors = [];

	/**
	 * Authentication constructor
	 *
	 * @param \CENSUS\Model\Request $request
	 * @throws \CENSUS\Core\Exception
	 */
    public function __construct(\CENSUS\Model\Request $request)
    {
		if (!($request instanceof \CENSUS\Model\Request)) {
			throw new \CENSUS\Core\Exception('Validation error, invalid Request', \CENSUS\Core\Exception::ERR_INVALID);
		}

        $this->errors = [];
		$this->request = $request;
		$this->loginTime = $this->request->getArgument('timestamp');
    }

    /**
     * Authenticate by requested user and password
     */
    public function authenticate()
    {
		if (true === $this->validateFormRequest()) {
			$localUserData = $this->getUserData();

			if (
				false !== $localUserData &&
				$localUserData['name'] == $this->request->getArgument('user') &&
				true === $this->verifyPassword($localUserData['ptoken'])
			) {
				unset ($localUserData['ptoken']);

				$this->setIsValid(true);
				$this->clearAttempt();
				$this->initializeSession($localUserData);
			} else {
				$this->authenticationAttempt();
				$this->addError('authenticationError', true);
			}

			unset ($localUserData);
		}
    }

	/**
	 * Validate the form request
	 *
	 * @return bool
	 */
	private function validateFormRequest()
	{
		if (true === $this->getIsLocked()) {
			$this->addError('authenticationError', true);
			$this->setIsValid(false);

			return false;
		}

		if ($this->loginTime < (time() - (600))) {
			$this->addError('timeoutError', true);
			$this->setIsValid(false);

			return false;
		}

		return true;
	}

	/**
	 * Get the user data
	 *
	 * @return bool|array
	 */
	private function getUserData()
	{
		$userName = $this->request->getArgument('user');
		$userDataFile = $this->userDir . $this->getHash($userName) . '.php';

		if (!file_exists($userDataFile)) {
			$this->addError('authenticationError', true);
			return false;
		}

		return require_once $userDataFile;
	}

	/**
	 * Verify the password
	 *
	 * @param string $password
	 * @return bool
	 */
    private function verifyPassword(string $password)
	{
		return password_verify($this->request->getArgument('password'), $password);
	}

	/**
	 * Log attempts with current time and lock authentication after too many failures
	 */
	private function authenticationAttempt()
	{
		if (isset($_SESSION['attempt'])) {
			if ($_SESSION['attempt']['counter'] >= 5) {
				$_SESSION['attempt']['from'] = $_SERVER['HTTP_HOST'];
				header('HTTP/1.1 503 Service Temporarily Unavailable');

				// @todo log. notify admin (too)?
				exit;
			}

			$_SESSION['attempt']['counter']++;
		} else {
			$_SESSION['attempt'] = [
				'counter' => 1,
				'time' => time()
			];
		}

		if (isset($_SESSION['attempt']) && $_SESSION['attempt']['time'] < (time() - 600)) {
			unset($_SESSION['attempt']);
		}
	}

	/**
	 * Clear attempt sesseion
	 */
	private function clearAttempt()
	{
		if (isset($_SESSION['attempt'])) {
			unset($_SESSION['attempt']);
		}
	}

	/**
	 * Verify authentication lock
	 */
	public function getIsLocked()
	{
		if ($_SESSION['attempt']['counter'] >= 3) {
			$this->setIsValid(false);
			return true;
		}

		return false;
	}

	/**
	 * Get the available attempt count
	 *
	 * @return int
	 */
	public function getAvailableAttempts()
	{
		return (3 - $_SESSION['attempt']['counter']);
	}

    /**
     * Set user authentication valid state
     * @param bool $isValid
     */
	private function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }
    /**
     * Get user authentication valid state
     *
     * @return bool
     */
	public function getIsValid()
	{
		return $this->isValid;
	}

    /**
     * Add error
     *
     * @param string $key
     * @param mixed $value
     */
	private function addError(string $key, $value)
    {
        $this->errors[$key] = $value;
    }

    /**
     * Get the errors
     *
     * @return array
     */
	public function getErrors()
    {
        return $this->errors;
    }

	/**
	 * Get a hash
	 *
	 * @param string $string
	 * @return string
	 */
	private function getHash(string $string)
	{
		return hash('sha256', $string);
	}

	/**
	 * Initialize the session with data
	 *
	 * @param array $userData
	 */
    private function initializeSession(array $userData)
    {
        $_SESSION['censuscms'] = [
			'name' => $userData['name'],
			'role' => $userData['role'],
			'data' => $userData['data'],
			'login' => $this->loginTime,
			'identifier' => $this->getHash($this->loginTime . $_SERVER['REMOTE_ADDR'])
		];

        unset($userData);
    }
}
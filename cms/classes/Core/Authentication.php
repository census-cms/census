<?php
namespace CENSUS\Core;

/**
 * Class Authentication
 *
 * @package CENSUS\Core
 * @todo add counter for wrong user/password requests and set session to deniy authentication for n:seconds
 */
class Authentication
{
    private $userDir = BASE_DIR . '/storage/userdata/user/';

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
     * @throws \CENSUS\Core\Exception
     */
    public function __construct()
    {
        $this->errors = [];
    }

    public function initializeAuthentication($request)
    {
        if (!($request instanceof \CENSUS\Model\Request)) {
            throw new \CENSUS\Core\Exception('Validation error, invalid Request', \CENSUS\Core\Exception::ERR_INVALID);
        }

        $this->request = $request;
        $this->loginTime = $this->request->getArgument('timestamp');

        $this->validateFormRequest();

        $auth = (empty($this->getErrors())) ? $this->authenticate() : [];

        if (true === $this->getIsValid()) {
            $this->setSession($auth);
        }

        return $this->getIsValid();
    }

    /**
     * Validate the form request
     *
     * @return bool
     */
    private function validateFormRequest()
    {
        if ($this->loginTime < (time() - (600))) {
            $this->errors['timeoutError'] = true;
        }
    }

    /**
     * Authenticate by requested user and password
     *
     * @return array|bool
     */
    private function authenticate()
    {
        $userData = $this->getUserData();

        if (
            $userData['name'] == $this->request->getArgument('user') &&
            true === $this->verifyPassword($this->request->getArgument('password'))
        ) {
            $this->setIsValid(true);

            $sessionData = [
                'name' => $userData['name'],
                'role' => (true === $userData['admin']) ? 'admin' : $userData['role'],
                'data' => $userData['data'],
                'login' => $this->loginTime,
				'identifier' => $this->getHash($this->loginTime . $_SERVER['REMOTE_ADDR'])
            ];

            unset($userData);

            return $sessionData;
        } else {
            $this->addError('authenticationError', true);
        }

        return false;
    }

	/**
	 * Verify the password
	 *
	 * @param string $password
	 * @return bool
	 */
    private function verifyPassword($password)
	{
		// must be copied also into the user create
		$hash = password_hash($this->request->getArgument('password'), PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);

		// this is the password verify
		return password_verify($password, $hash);
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
			return false;
		}

		return require_once $userDataFile;
	}

	/**
	 * Get a hash
	 *
     * @param string $string
	 * @return string
	 */
	private function getHash($string)
	{
		return hash('sha256', $string);
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
	private function addError($key, $value)
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
	 * Set the session variable with data
	 *
	 * @param $sessionData
	 */
    private function setSession($sessionData)
    {
        $_SESSION['censuscms'] = $sessionData;
    }
}
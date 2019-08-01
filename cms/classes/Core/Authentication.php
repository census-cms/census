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
     * Authentication constructor
     *
     * @param $request
     * @throws \CENSUS\Core\Exception
     */
    public function __construct($request)
    {
        if (!($request instanceof \CENSUS\Model\Request)) {
            throw new \CENSUS\Core\Exception('Validation error, invalid Request', \CENSUS\Core\Exception::ERR_INVALID);
        }

        $this->request = $request;
        $this->loginTime = time();

        $auth = $this->authenticate();

        if (true === $this->isValid) {
            $this->setSession($auth);
        }

        return $this->isValid;
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
            true === $this->verifyPassword($userData['ptoken'])
        ) {
            $this->isValid = true;

            $sessionData = [
                'name' => $userData['name'],
                'role' => (true === $userData['admin']) ? 'admin' : $userData['role'],
                'data' => $userData['data'],
                'login' => $this->loginTime,
				'identifier' => $this->getNewIdentifier()
            ];

            unset($userData);

            return $sessionData;
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
		$userDataFile = $this->userDir . $userName . '.php';

		if (!file_exists($userDataFile)) {
			return false;
		}

		return require_once $userDataFile;
	}

	/**
	 * Get a new identifier for the session
	 *
	 * @return string
	 */
	private function getNewIdentifier()
	{
		return hash('sha256', $this->loginTime . $_SERVER['REMOTE_ADDR']);
	}

	public function getIsValid()
	{
		return $this->isValid;
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

	/**
	 * Leaving authentication
	 */
    public function __destruct()
    {
        $this->request = null;
    }
}
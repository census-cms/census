<?php
namespace CENSUS\Core;

/**
 * Class Authentication
 *
 * @package CENSUS\Core
 * @todo implement a secure password authentication (salted, hash password with JS on keyup, compare hashed passwords)
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
    protected function authenticate()
    {
        $userName = $this->request->getArgument('user');
        $userDataFile = $this->userDir . $userName . '.php';

        if (!file_exists($userDataFile)) {
            return false;
        }

        $userData = require_once $userDataFile;

        if (
            $userData['name'] == $this->request->getArgument('user') &&
            $userData['ptoken'] == $this->request->getArgument('password')
        ) {
            $this->isValid = true;

            $sessionData = [
                'name' => $userData['name'],
                'role' => (true === $userData['admin']) ? 'admin' : $userData['role'],
                'data' => $userData['data'],
                'login' => time()
            ];

            unset($userData);

            return $sessionData;
        }
    }

    private function setSession($sessionData)
    {
        $_SESSION['censuscms'] = $sessionData;
    }

    public function __destruct()
    {
        $this->request = null;
        header('Location: /backend/');
    }
}
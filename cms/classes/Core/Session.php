<?php
namespace CENSUS\Core;


class Session
{
    /**
     * @var \CENSUS\Model\Session
     */
    private $session = null;

    /**
     * Session constructor
     */
    public function __construct()
    {
        session_start();

        $this->initializeSession();

        return $this->getSession();
    }

    /**
     * Initialize the session and it's data
     */
    private function initializeSession()
    {
        $this->session = new \CENSUS\Model\Session();
    }

    /**
     * Get the session
     *
     * @return \CENSUS\Model\Session
     */
    private function getSession()
    {
        return $this->session;
    }

    /**
     * Check if session is still valid
     * @todo get session lifetime from configuration
     */
    public function isAuthenticated()
    {
        if (false !== $this->session->isActive) {
            if ($this->session->getLoginTime() < (time() - 3600*2)) {
                $this->logout();
            }
        }
    }

    /**
     * Logout
     * destroy current session
     */
    public function logout()
    {
        session_destroy();
    }
}
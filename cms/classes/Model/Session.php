<?php
namespace CENSUS\Model;


class Session
{
    /**
     * Session is active
     *
     * @var bool
     */
    public $isActive = false;

    /**
     * Name
     *
     * @var string
     */
    private $name = '';

    /**
     * Role
     *
     * @var int
     */
    private $role = 0;

    /**
     * Data
     *
     * @var array
     */
    private $data = [];

    /**
     * Login tinestamp
     *
     * @var int
	 * @throws \CENSUS\Core\Exception
     */
    private $loginTime = 0;

	/**
	 * Session constructor
	 *
	 * @throws \CENSUS\Core\Exception
	 */
    public function __construct()
    {
        list ($class, $caller) = debug_backtrace(false, 2);

        if ($caller['class'] !== 'CENSUS\Core\Session') {
            throw new \CENSUS\Core\Exception('Access to session data model is restricted', \CENSUS\Core\Exception::ERR_NOT_ALLOWED);
        }

        if (isset($_SESSION['censuscms'])) {
            $s = $_SESSION['censuscms'];

            $this->isActive = true;

            $this->setName($s['name']);
            $this->setRole($s['role']);
            $this->setData($s['data']);
            $this->setLoginTime($s['login']);

            unset($s);
        } else {
            $this->isActive = false;
        }
    }

    /**
     * Set the name
     *
     * @param string $name
     */
    private function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Set the role
     *
     * @param int $role
     */
    private function setRole(int $role)
    {
        $this->role = $role;
    }

    /**
     * Set the data
     *
     * @param array $data
     */
    private function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set the login timestamp
     *
     * @param int $tstamp
     */
    private function setLoginTime(int $tstamp)
    {
        $this->loginTime = $tstamp;
    }

    /**
     * Get the login time
     *
     * @return int
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }
}
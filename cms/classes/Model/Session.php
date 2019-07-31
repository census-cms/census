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
     */
    private $loginTime = 0;

    public function __construct()
    {
        list ($class, $caller) = debug_backtrace(false, 2);

        if ($caller['class'] !== 'CENSUS\Core\Session') {
            throw new \Exception('Access to session data model is restricted', 1103);
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
    private function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set the role
     *
     * @param int $role
     */
    private function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Set the data
     *
     * @param array $data
     */
    private function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Set the login timestamp
     *
     * @param int $tstamp
     */
    private function setLoginTime($tstamp)
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
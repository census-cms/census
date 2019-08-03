<?php
namespace CENSUS\Core\Controller;


class AuthenticationController extends CommandController
{
    /**
     * @var \CENSUS\Core\Authentication
     */
    private $authentication = null;

	/**
	 * User login
	 */
    protected function loginAction()
    {
        $this->authentication = new \CENSUS\Core\Authentication($this->request);
		$this->view->setLayout('_login.html');

        if (
            $this->request->hasArgument('auth') &&
            $this->request->hasArgument('user') &&
            $this->request->hasArgument('password') &&
            (
                !empty($this->request->getArgument('user')) &&
                !empty($this->request->getArgument('password'))
            )
        ) {
			$this->authentication->authenticate();

			if (true === $this->authentication->getIsValid()) {
				$this->redirect('/backend/');
			}
        }

        $this->view->assign(
            [
                'timestamp' => time(),
                'valid' => $this->authentication->getIsValid(),
                'errors' => $this->authentication->getErrors(),
				'locked' => $this->authentication->getIsLocked(),
				'retryCount' => $this->authentication->getAvailableAttempts()
            ]
        );
    }

	/**
	 * User logout
	 */
    protected function logoutAction()
	{
		$this->getApplication()->initializeLogout();
		$this->redirect('/backend/');
	}
}
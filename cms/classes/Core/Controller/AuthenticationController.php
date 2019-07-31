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
        if (
            $this->request->hasArgument('auth') &&
            $this->request->hasArgument('user') &&
            $this->request->hasArgument('password') &&
            (
                !empty($this->request->getArgument('user')) &&
                !empty($this->request->getArgument('password'))
            )
        ) {
            $this->authentication = new \CENSUS\Core\Authentication($this->request);

            $this->redirect('/backend/');
        }

        $this->view->render('login.html');
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
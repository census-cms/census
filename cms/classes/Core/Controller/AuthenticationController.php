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
        $this->authentication = new \CENSUS\Core\Authentication();

        if (
            $this->request->hasArgument('auth') &&
            $this->request->hasArgument('user') &&
            $this->request->hasArgument('password') &&
            (
                !empty($this->request->getArgument('user')) &&
                !empty($this->request->getArgument('password'))
            )
        ) {
            if (true === $this->authentication->initializeAuthentication($this->request)) {
                $this->redirect('/backend/');
            }
        }

        $this->view->render(
            'login.html',
            [
                'timestamp' => time(),
                'valid' => $this->authentication,
                'errors' => $this->authentication->getErrors()
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
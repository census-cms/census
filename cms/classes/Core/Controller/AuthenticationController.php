<?php
namespace CENSUS\Core\Controller;


class AuthenticationController extends CommandController
{
    /**
     * @var \CENSUS\Core\Authentication
     * @Inject
     */
    private $authentication = null;

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
        }

        $this->view->render('login.html');
    }
}
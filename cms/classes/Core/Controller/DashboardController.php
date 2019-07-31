<?php
namespace CENSUS\Core\Controller;


class DashboardController extends CommandController
{
    protected function overviewAction()
    {
        $this->view->render('overview.html');
    }
}
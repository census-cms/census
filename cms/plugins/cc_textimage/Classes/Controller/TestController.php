<?php
namespace CENSUS\CcTextimage\Controller;

class TestController extends \CENSUS\Core\Controller\CommandController
{
    public $context = 'cc_textimage';

    public function indexAction()
    {
        echo 'test controller => index action';
    }

    public function fooAction()
    {
        echo 'test controller => foo action';
    }
}
<?php

use Ingresse\Consumer\Facebook as FacebookConsumer;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $url = $this->di->get('facebookService')->getUrl();
        $this->view->setVar("url", $url);
    }

    public function callbackAction()
    {
        $session = $this->di->get('facebookService')->getSession();

        if ( $session ) {
            $this->di->get('facebookService')
                     ->setStorage($this->di->get('storageService'));

            $this->di->get('facebookService')->searchAndSaveEvents();

            $fbId = $this->di->get('facebookService')->getProfile()['id'];

            $this->response->redirect('Index/show/'.$fbId);
        } else {
            $this->response->redirect();
        }
    }

    public function showAction()
    {
        $this->di->get('facebookService')
                 ->setStorage($this->di->get('storageService'));

        $events = $this->di->get('facebookService')->getEventsStored(
            $this->dispatcher->getParams()[0]
        );

        $this->view->setVar("events", $events);
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('Index/index');
    }
}


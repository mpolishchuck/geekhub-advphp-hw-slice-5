<?php

namespace PaulMaxwell\GuestbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PaulMaxwellGuestbookBundle:Default:index.html.twig');
    }
}

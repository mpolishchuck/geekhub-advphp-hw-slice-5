<?php

namespace PaulMaxwell\GuestbookBundle\Controller;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($page = 1)
    {
        $manager = $this->getDoctrine()->getManager();
        /**
         * @var Query $query
         */
        $query = $manager->createQuery('SELECT t FROM PaulMaxwellGuestbookBundle:Message t ORDER BY t.postedAt DESC');

        /**
         * @var Paginator $paginator
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page
        );

        $form = $this->createForm('post');

        $form->handleRequest($this->getRequest());
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $manager->persist($message);
            $manager->flush();

            return $this->redirect($this->generateUrl('paul_maxwell_guestbook_homepage'));
        }

        return $this->render('PaulMaxwellGuestbookBundle:Default:index.html.twig', array(
            'posts' => $pagination,
            'form' => $form->createView(),
        ));
    }
}

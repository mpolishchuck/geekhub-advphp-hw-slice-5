<?php

namespace PaulMaxwell\GuestbookBundle\Controller;

use Doctrine\ORM\Query;
use PaulMaxwell\GuestbookBundle\Event\NewMessageAddedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = $this->getRequest();

        $after_id = $request->get('after_id');
        $before_id = $request->get('before_id');

        $manager = $this->getDoctrine()->getManager();
        /**
         * @var \PaulMaxwell\GuestbookBundle\Entity\MessageRepository $repository
         */
        $repository = $manager->getRepository('PaulMaxwellGuestbookBundle:Message');

        $form = $this->createForm('post');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $manager->persist($message);
            $manager->flush();

            $event = new NewMessageAddedEvent();
            $event->setMessage($message);
            /**
             * @var \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
             */
            $eventDispatcher = $this->get('event_dispatcher');
            $eventDispatcher->dispatch('paul_maxwell_guestbook_bundle.new_message_added', $event);

            if ($request->isXmlHttpRequest()) {
                /**
                 * This feature is not used by client
                 */
                return $this->render('PaulMaxwellGuestbookBundle:Default:_posts.html.twig', array(
                    'posts' => ($before_id !== null) ? $repository->findSliceBeforeId($before_id) : array(),
                    'disableShowMore' => true,
                ));
            } else {
                return $this->redirect($this->generateUrl('paul_maxwell_guestbook_homepage'));
            }
        }

        /**
         * @var \PaulMaxwell\GuestbookBundle\Entity\Message[] $posts
         */
        if ($after_id !== null) {
            $posts = $repository->findSliceAfterId($after_id, $this->container->getParameter('posts_on_page_count'));
        } elseif ($before_id !== null) {
            $posts = $repository->findSliceBeforeId($before_id, $this->container->getParameter('posts_on_page_count'));
            $posts = array_reverse($posts);
        } else {
            $posts = $repository->findFirstSlice($this->container->getParameter('posts_on_page_count'));
        }

        if (count($posts) > 0) {
            $hasPrevious = $repository->hasMessagesBefore($posts[0]->getId());
            $hasNext = $repository->hasMessagesAfter($posts[count($posts) - 1]->getId());
        } else {
            $hasPrevious = false;
            $hasNext = false;
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('PaulMaxwellGuestbookBundle:Default:_posts.html.twig', array(
                'posts' => $posts,
                'disableShowMore' => !$hasNext,
            ));
        } else {
            return $this->render('PaulMaxwellGuestbookBundle:Default:index.html.twig', array(
                'posts' => $posts,
                'form' => $form->createView(),
                'enableShowPrevious' => (($before_id !== null) || ($after_id !== null)) && $hasPrevious,
                'disableShowMore' => !$hasNext,
            ));
        }
    }

    public function removeAction($id, $page = 1)
    {
        $manager = $this->getDoctrine()->getManager();
        $entity = $manager->getRepository('PaulMaxwell\GuestbookBundle\Entity\Message')->find($id);
        $manager->remove($entity);
        $manager->flush();

        return $this->redirect(
            $this->generateUrl(
                'paul_maxwell_guestbook_page',
                array(
                    'page' => $page,
                )
            )
        );
    }
}

<?php

namespace PaulMaxwell\GuestbookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PaulMaxwell\GuestbookBundle\Entity\Message;

class LoadBasicMessages implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $message = new Message();

            $message->setName("Guest $i");
            $message->setEmail("guest$i@local.net");
            $message->setMessageBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ligula sapien, commodo et dictum ut, semper eget diam. In hac habitasse platea dictumst. Fusce faucibus mi id nulla lacinia, in elementum est lacinia. Pellentesque congue tincidunt cursus. Sed commodo tempus dapibus. Vivamus at sapien aliquam, gravida lorem non, tristique lorem. Nunc suscipit dolor eu risus tristique, fringilla pellentesque sem ultrices. Maecenas ante tellus, tempus ut semper a, porta eu libero. Integer consectetur nulla eu pretium tempor. Etiam sed pretium ante. Mauris pulvinar turpis sed hendrerit mattis.');

            $manager->persist($message);
        }

        $manager->flush();

        $messages = $manager->getRepository('PaulMaxwellGuestbookBundle:Message')->findAll();
        $counter = 0;
        foreach ($messages as $message) {
            /**
             * @var \PaulMaxwell\GuestbookBundle\Entity\Message $message
             */
            $message->setPostedAt(new \DateTime('2013-12-' . (++$counter)));
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}

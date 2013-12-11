<?php

namespace PaulMaxwell\GuestbookBundle\Event;

use PaulMaxwell\GuestbookBundle\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

class NewMessageAddedEvent extends Event
{
    /**
     * @var \PaulMaxwell\GuestbookBundle\Entity\Message
     */
    protected $message = null;

    /**
     * @param \PaulMaxwell\GuestbookBundle\Entity\Message $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return \PaulMaxwell\GuestbookBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}

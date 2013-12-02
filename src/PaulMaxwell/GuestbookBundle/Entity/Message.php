<?php

namespace PaulMaxwell\GuestbookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraint;

/**
 * Class Message
 * @package PaulMaxwell\GuestbookBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="message")
 */
class Message
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="message_body", type="text")
     */
    protected $messageBody;

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $messageBody
     */
    public function setMessageBody($messageBody)
    {
        $this->messageBody = $messageBody;
    }

    /**
     * @return string
     */
    public function getMessageBody()
    {
        return $this->messageBody;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

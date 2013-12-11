<?php

namespace PaulMaxwell\GuestbookBundle\EventListener;

use MyProject\Proxies\__CG__\stdClass;
use PaulMaxwell\GuestbookBundle\Event\NewMessageAddedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class GuestbookListener
{
    protected $mailer = null;
    protected $logger = null;
    protected $adminEmail = null;
    protected $translator = null;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setAdminEmail($adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function onMessageAdded(NewMessageAddedEvent $event)
    {
        if ($this->translator instanceof TranslatorInterface) {
            $translator = $this->translator;
        } else {
            $translator = new \stdClass();
            $translator->trans = function ($string, $parameters = array()) {
                return strtr($string, $parameters);
            };
        }

        $messagePost = $event->getMessage();

        if ($this->logger instanceof LoggerInterface) {
            $this->logger->info($translator->trans(
                'New post added into guestbook from {name} on {time}',
                array(
                    '{name}' => $messagePost->getName(),
                    '{time}' => $messagePost->getPostedAt()->format('d.m.Y H:i:s'),
                )
            ));
        }

        if ($this->mailer instanceof \Swift_Mailer) {
            /**
             * @var \Swift_Message $message
             */
            $message = $this->mailer->createMessage();
            $message->setTo(array($this->adminEmail));
            $message->setFrom($this->adminEmail);
            $message->setSubject($translator->trans('New post notification'));
            $message->setContentType('text/plain');
            $message->setCharset('utf-8');
            $message->setBody(
                $translator->trans("New post added into guest book.\nSender: {name}\nTime: {time}\n\n{body}\n", array(
                    '{name}' => $messagePost->getName(),
                    '{time}' => $messagePost->getPostedAt()->format('d.m.Y H:i:s'),
                    '{body}' => $messagePost->getMessageBody(),
                ))
            );
            $this->mailer->send($message);
        }
    }
}

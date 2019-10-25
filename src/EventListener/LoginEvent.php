<?php

namespace App\EventListener;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginEvent
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractivelogin(InteractiveLoginEvent $logEvent)
    {
        $user = $logEvent->getAuthenticationToken()->getUser();
        $user->setLastLog(new DateTime());
        $this->em->persist($user);
        $this->em->flush();
    }
}
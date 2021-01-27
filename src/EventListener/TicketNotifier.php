<?php
/**
 * Created by PhpStorm.
 * User: geoffroycochard
 * Date: 27/01/2021
 * Time: 14:48
 */

namespace App\EventListener;


use App\Entity\Ticket;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class TicketNotifier
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * TicketNotifier constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Ticket $ticket
     * @param LifecycleEventArgs $eventArgs
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function postPersist(Ticket $ticket, LifecycleEventArgs $eventArgs)
    {
        foreach ($ticket->getUsers() as $user) {
            dump($user->getEmail());
            $email = new Email();
            $email
                ->to($user->getEmail())
                ->subject('New ticket ' . $ticket->getTitle())
                ->text('Un nouveau...'. $ticket->getDescription())
            ;
            $this->mailer->send($email);
        }
    }

}


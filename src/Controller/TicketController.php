<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/create-tickets-with-category")
     */
    public function createTicketWithCategory(): Response
    {
        $category = (new Category())->setTitle('category');

        $ticket = (new Ticket())
            ->setTitle('Ticket title')
            ->setDescription('description')
            ->setCategory($category)
        ;

        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();


        return new Response('ticket created');

    }


    /**
     * @return Response
     *
     * @Route("/create-user-tickets")
     */
    public function createNewUsersAndAssignToTickets(): Response
    {
        // Users create
        $em = $this->getDoctrine()->getManager();
        $users = [];
        foreach (['geoffroycohard', 'bot'] as $username) {
            $users[] = $user = (new User())->setUsername($username);
            $em->persist($user);
        }
        $em->flush();

        // Assign users to existing tickets

        $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        /** @var Ticket $ticket */
        foreach ($tickets as $ticket) {
            foreach ($users as $user) {
                $ticket->addUser($user);
                dump($ticket);
            }
        }
        $em->flush();

        return new Response('crated');

    }
}

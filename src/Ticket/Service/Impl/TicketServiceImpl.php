<?php
namespace Ticket\Service\Impl;

use Ticket\Service\ITicketService;
use Doctrine\ORM\EntityManager;
use Ticket\Entity\Ticket;
use Ticket\Exception\EntityNotFoundException;

class TicketServiceImpl implements ITicketService {
	
	private $ticketRepository;
	private $entityManager;
	
	public function __construct(EntityManager $em) {
            $this->ticketRepository = $em->getRepository("Ticket\Entity\Ticket");
            $this->entityManager = $em;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ITicketService::getAllTickets()
	 */
	public function getAllTickets() {
            return $this->ticketRepository->findAll();
	}

	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ITicketService::getTicketById()
	 */
	public function getTicketById($id) {
            return $this->ticketRepository->find($id);
	}

        /**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ITicketService::getTicketByUser()
	 */
        public function getTicketsByUser(User $user) {
            return $this->ticketRepository->findBy(array("user" => $user), array("createdAt" => "DESC"));
        }

	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ITicketService::createTicket()
	 */
	public function createTicket(Ticket $ticket) {
            $this->entityManager->persist($ticket);
            $this->entityManager->flush();
            
            return $ticket;
	}
}
<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="back.")
 */
class BackController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     */
    public function login()
    {
        return $this->render('back/index.html.twig', [

        ]);
    }

    /**
     * @Route("/tableau-de-bord", name="dashboard", methods={"GET|POST"})
     * @param EventRepository $eventRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard(EventRepository $eventRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreatedAt(new \DateTime());
            $entityManager->persist($event);
            $entityManager->flush();
        }

        $events = $eventRepository->findBy([], ['id' => 'desc']);
        return $this->render('back/dashboard.html.twig', [
            'events'    => $events,
            'form'      => $form->createView()
        ]);
    }


    /**
     * @Route("/suppression-de-l-evenement/{id}", name="event.delete", methods={"DELETE"})
     * @param Event $event
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     */
    public function delete(Event $event, EntityManagerInterface $entityManager, Request $request) {
        if ($this->isCsrfTokenValid('delete_event_'.$event->getId(), $request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash('success', 'L\'évènement a bien été supprimé');
        } else {
            $this->addFlash('danger', 'Une erreur a eu lieu avec cette action');
        }
        return $this->redirectToRoute('back.dashboard');
    }

    /**
     * @Route("/modification-de-l-evenement/{id}", name="event.edit", methods={"GET|POST"})
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Event $event, Request $request, EntityManagerInterface $entityManager) {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
        }

        return $this->render('back/edit-event.html.twig', [
            'event'    => $event,
            'form'      => $form->createView()
        ]);
    }

}

<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/tableau-de-bord", name="dashboard")
     * @param EventRepository $eventRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();
        dump($events);
        return $this->render('back/dashboard.html.twig', [
            'events'    => $events
        ]);
    }

}

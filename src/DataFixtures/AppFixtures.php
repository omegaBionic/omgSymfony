<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $events = ['virus', 'home-office', 'confinement', 'formation PHP', 'famine', 'décès'];

        foreach ($events as $event) {
            $e = new Event();
            $e->setName($event);
            $e->setCreatedAt(new \DateTime());
            $manager->persist($e);
        }

        $manager->flush();
    }
}

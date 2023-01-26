<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $statusNames = [
            'Commandée',
            'Rendez-vous pris',
            'Rendez-vous manqué',
            'Rendez-vous effectué',
            'Payée',
            'Erreur Paiement',
            'Contrôle technique',
            'Livraison',
            'Livrée et terminée',
        ];
        $statusSlug = [
            'ordered',
            'appointment',
            'missed-appointment',
            'appointment-done',
            'paid',
            'payment-error',
            'technical-control',
            'delivery',
            'delivered-and-finished',
        ];
        foreach ($statusNames as $key => $statusName) {
            $status = new Status();
            $status->setName($statusName);
            $status->setSlug($statusSlug[$key]);
            $manager->persist($status);
        }


        $manager->flush();
    }
}

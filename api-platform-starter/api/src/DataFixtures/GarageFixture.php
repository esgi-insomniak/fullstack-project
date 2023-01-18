<?php

namespace App\DataFixtures;

use App\Entity\Garage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GarageFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $garage = new Garage();
            $garage->setName($faker->company);
            $garage->setCoordinates([$faker->latitude, $faker->longitude]);
            $garage->setIsOpen($faker->boolean);
            $manager->persist($garage);
        }

        $manager->flush();
    }
}

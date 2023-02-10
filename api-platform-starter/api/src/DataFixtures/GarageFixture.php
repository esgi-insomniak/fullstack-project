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
        //France coordinates 4 corners
        $minLat = 41.3;
        $maxLat = 51.1;
        $minLng = -5.6;
        $maxLng = 9.6;
        for ($i = 0; $i < 100; $i++) {
            $latitudes = $faker->latitude($min = $minLat, $max = $maxLat);
            $longitudes = $faker->longitude($min = $minLng, $max = $maxLng);

            $garage = new Garage();
            $garage->setName($faker->company);
            $garage->setCoordinates([$latitudes, $longitudes]);
            $garage->setIsOpen($faker->boolean);
            $manager->persist($garage);
        }

        $manager->flush();
    }
}

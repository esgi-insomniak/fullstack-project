<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarCategory;
use App\Entity\Garage;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Fakecar;

class CarFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Fakecar($faker));
        $garages = $manager->getRepository(Garage::class)->findAll();
        $carCategories = $manager->getRepository(CarCategory::class)->findAll();
        $images = $manager->getRepository(Image::class)->findAll();
        for ($i = 0; $i < 500; $i++) {
            $carName = $faker->unique()->vehicle;
            $carNameSlug = uniqid("", true);
            $carOptions = array_values($faker->vehicleProperties);
            $car = new Car();
            $car->setCategory($carCategories[array_rand($carCategories)]);
            $car->setName($carName);
            $car->setSlug($carNameSlug);
            $car->setYear($faker->year);
            $car->setOptions($carOptions);
            $car->setPrice($faker->randomFloat(2, 1000, 100000));
            $car->setFuel($faker->vehicleFuelType);
            $car->setPower($faker->randomFloat(2, 50, 1000));
            $car->setWeight($faker->randomFloat(2, 500, 5000));
            $car->setSpeeding($faker->randomFloat(2, 2, 20));
            $car->setConsumption($faker->randomFloat(2, 2, 20));
            for ($j = 0; $j < $faker->randomNumber(1); $j++) {
                $car->addGarage($garages[array_rand($garages)]);
            }
            $car->setCategory($carCategories[array_rand($carCategories)]);
            $car->setMileage($faker->randomNumber(5));
            $car->setGearboxType($faker->vehicleGearBoxType);
            $car->addImage($images[array_rand($images)]);

            $manager->persist($car);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ImagesFixture::class,
            GarageFixture::class,
            CarCategoryFixture::class,
        ];
    }
}

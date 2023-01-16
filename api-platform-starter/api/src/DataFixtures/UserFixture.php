<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pwd = "$2y$13$1LJzqnNyoUOY29DUzfigVu9.V09oruc3ynZX9413wNmlTGErr3I1G";

        $fakeUser = new User();
        $fakeUser->setEmail("user@user.fr");
        $fakeUser->setPassword($pwd);
        $fakeUser->setRoles(['ROLE_USER']);
        $fakeUser->setFirstName("User");
        $fakeUser->setLastName("User");
        $fakeUser->setVerifiedAt(new \DateTimeImmutable());
        $fakeUser->setCoordinates(["48.856614","2.3522219"]);
        $fakeUser->setCreatedAt(new \DateTimeImmutable());
        $fakeUser->setUpdatedAt(null);

        $manager->persist($fakeUser);
        $manager->flush();
    }
}

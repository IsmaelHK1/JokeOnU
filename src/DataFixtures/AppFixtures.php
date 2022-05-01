<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Joke;
use App\Entity\Like;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Blagues\BlaguesApi;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);

        $faker = Faker\Factory::create('fr_FR');

        $jokes = [];
        for ($i = 1; $i < 150; $i++) {
            $jokefromapi = $blaguesApi->getRandom();
            $joke = new joke();
            $joke->setLikes($faker->randomDigitNot(2));
            $joke->setKeyApi($jokefromapi->getId());
            $manager->persist($joke);
            $jokes[] = $joke;
        }
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new user();
            $user->setUsername($faker->userName())
                ->setPassword($faker->password())
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setJoke($faker->randomElement($jokes));
            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 0; $i < 15; $i++) {
            $like = new like();
            $like->setUser($faker->randomElement($users));
            $like->setJoke($faker->randomElement($jokes));
            $manager->persist($like);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Joke;
use App\Entity\Like;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $jokes = [];
        for ($i = 0; $i < 40; $i++) {
            $joke = new joke();
            $joke->setLikes($faker->randomDigitNot(2));
            $manager->persist($joke);
            $jokes[] = $joke;
        }
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new user();
            $user->setPseudo($faker->userName())
                ->setPassword($faker->password())
                ->setEmail($faker->email())
                ->setJoke($faker->randomElement($jokes));
                $manager->persist($user);
                $users[] = $user;
        }

        for ($i = 0; $i < 100; $i++) {
            $like = new like();
            $like->setUser($faker->randomElement($users));
                $manager->persist($like);
        }
        
        $manager->flush();
    }
}   
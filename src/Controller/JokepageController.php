<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blagues\BlaguesApi;
use App\Entity\User;
use App\Repository\JokeRepository;
use App\Repository\UserRepository;
use Faker;


class JokepageController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(JokeRepository $jokeRepository, UserRepository $userRepository): Response
    {
        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);
        $alluser = $userRepository->findAll();
        shuffle($alluser);


        //recuperation d'une blague a partir d'un user random
        $oneJoke = $alluser[1]->getJoke();
        $oneJoke = $jokeRepository->findOneBy(array('id' => $oneJoke->getId()));
        $jokesfromApi = $blaguesApi->getbyId($oneJoke->getKeyApi());

        return $this->render('jokepage/index.html.twig', [
            'controller_name' => 'JokepageController',
            'jokes' => $jokesfromApi,
        ]);
    }
}

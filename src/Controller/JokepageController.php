<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blagues\BlaguesApi;
use App\Repository\JokeRepository;
use App\Repository\UserRepository;

class JokepageController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(JokeRepository $jokeRepository, UserRepository $userRepository): Response
    {
        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);

        //recuperation d'une blague a partir d'un user random
        $oneUser = $userRepository->getRandom();
        $oneUser = $oneUser->getJoke_id();

        $oneJoke = $jokeRepository->findOneBy($oneUser);
        $jokesfromApi = $blaguesApi->getbyId(intval($oneJoke->getKeyApi()));
        var_dump($jokesfromApi->getJoke());
        var_dump($jokesfromApi->getAnswer());

        return $this->render('jokepage/index.html.twig', [
            'controller_name' => 'JokepageController',
            'joke_key' => $jokesfromApi,
        ]);
    }
}

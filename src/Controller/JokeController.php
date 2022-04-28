<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blagues\BlaguesApi;

class JokeController extends AbstractController
{
    #[Route('/joke', name: 'app_joke')]
    public function index(): Response
    { 
        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);

        $joke = $blaguesApi->getRandom(); // Returns an object of class Blagues\Models\Joke

        var_dump($joke->getJoke()); // This returns the actual joke.
        var_dump($joke->getAnswer()); // And this return the answer to the joke if there is one.


        return $this->render('joke/index.html.twig', [
            'controller_name' => 'JokeController',
            'joke_key' => $joke,
        ]);
    }
}

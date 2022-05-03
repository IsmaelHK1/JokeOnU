<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\JokeRepository;
use Blagues\BlaguesApi;
use App\Entity\User;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(JokeRepository $jokeRepository, UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }
        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);
        $userId =  $this->getUser()->getUserIdentifier();
        $oneJoke = $jokeRepository->findOneBy(array('id' => $userId));
        $jokesfromApi = $blaguesApi->getbyId($oneJoke->getKeyApi());

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'jokes' => $jokesfromApi,
        ]);
    }
}

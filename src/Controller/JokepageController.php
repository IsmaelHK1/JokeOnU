<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blagues\BlaguesApi;
use App\Entity\User;
use App\Entity\Like;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\LikeType;
use App\Repository\JokeRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

use Faker;


class JokepageController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(JokeRepository $jokeRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }


        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);
        $alluser = $userRepository->findAll();
        shuffle($alluser);

        //recuperation d'une blague a partir d'un user random
        $oneJoke = $alluser[1]->getJoke();
        $oneJoke = $jokeRepository->findOneBy(array('id' => $oneJoke->getId()));
        $jokesfromApi = $blaguesApi->getbyId($oneJoke->getKeyApi());

        //partie like
        $like = new Like();
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $like->setUser(
                // $this->getUser();
                $this->$userRepository->findOneBy(array('id' => $this->getUser()->getUserIdentifier()))
            )
                ->setJoke($oneJoke);
            $entityManager->persist($like);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }



        return $this->render('jokepage/index.html.twig', [
            'controller_name' => 'JokepageController',
            'jokes' => $jokesfromApi,
            'form' => $form->createView(),
        ]);
    }
}

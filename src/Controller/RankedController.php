<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Joke;
use App\Entity\Like;
use App\Repository\UserRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\Query\Expr\Join;
use App\Repository\JokeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Connection;

class RankedController extends AbstractController
{
    #[Route('/ranked', name: 'app_ranked')]
    public function index(LikeRepository $likeRepository, JokeRepository $jokeRepository, EntityManagerInterface $entityManager): Response
    {
        // $sql = $entityManager->createQueryBuilder('user');
        // $sql->select('username')
        //     ->from(User::class, 'user')
        //     ->innerJoin(Like::class, 'user_id', 'WITH', 'Like.user_id = user.id')
        //     ->innerJoin(Joke::class, 'id', 'WITH', 'Like.joke_id = joke.id')
        //     ->orderBy('joke.likes', 'DESC');

        // $rank = $sql->getQuery()->execute();

        $rank = array();
        $jonction = array();
        $jokeInOrder = $jokeRepository->findby(array(), array('likes' => 'DESC'));
        $jonction->$joke;

        return $this->render('ranked/index.html.twig', [
            'controller_name' => 'RankedController',
            'rank' => $rank
        ]);
    }
}

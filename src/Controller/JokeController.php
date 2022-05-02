<?php

namespace App\Controller;

use App\Entity\Joke;
use App\Form\JokeType;
use App\Repository\JokeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/joke')]
class JokeController extends AbstractController
{
    #[Route('/', name: 'app_joke_index', methods: ['GET'])]
    public function index(JokeRepository $jokeRepository): Response
    {
        return $this->render('joke/index.html.twig', [
            'jokes' => $jokeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_joke_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JokeRepository $jokeRepository): Response
    {
        $joke = new Joke();
        $form = $this->createForm(JokeType::class, $joke);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jokeRepository->add($joke);
            return $this->redirectToRoute('app_joke_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joke/new.html.twig', [
            'joke' => $joke,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joke_show', methods: ['GET'])]
    public function show(Joke $joke): Response
    {
        return $this->render('joke/show.html.twig', [
            'joke' => $joke,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_joke_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joke $joke, JokeRepository $jokeRepository): Response
    {
        $form = $this->createForm(JokeType::class, $joke);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jokeRepository->add($joke);
            return $this->redirectToRoute('app_joke_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joke/edit.html.twig', [
            'joke' => $joke,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joke_delete', methods: ['POST'])]
    public function delete(Request $request, Joke $joke, JokeRepository $jokeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joke->getId(), $request->request->get('_token'))) {
            $jokeRepository->remove($joke);
        }

        return $this->redirectToRoute('app_joke_index', [], Response::HTTP_SEE_OTHER);
    }
}

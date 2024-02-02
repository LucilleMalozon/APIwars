<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StarWarsAPIservice;

class HomeController extends AbstractController
{

    public function __construct(
        private readonly StarWarsAPIservice $starWarsApiService
    ){
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'characters' => $this->starWarsApiService->getCharacters(),
        ]);
    }

    #[Route('/character/{id}', name: 'app_character', requirements: ['id' => '\d+'])]
    public function character(int $id): Response
    {
        return $this->render('home/character.html.twig', [
            'character' => $this->starWarsApiService->getCharacter($id),
        ]);
    }
}

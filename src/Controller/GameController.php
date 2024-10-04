<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/choose', name: 'app_choose')]
    public function choose(ThemeRepository $themeRepository): Response
    {
        $themes = $themeRepository->findAll();
        return $this->render('game/choose.html.twig', [
            'themes' => $themes,
        ]);
    }

    #[Route('/game', name: 'app_game')]
    public function play(CardRepository $cardRepository, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $themeId = $request->query->get('theme');
        $cards = $cardRepository->findBy(['idTheme' => $themeId]);

        $images = [];
        foreach ($cards as $card) {
            $images[] = $card->getImgPath();
        }

        return $this->render('game/game.html.twig', [
            'images' => $images,
        ]);
    }
}
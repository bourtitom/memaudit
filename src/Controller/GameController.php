<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/choose', name: 'app_choose')]
    public function choose(): Response
    {
        return $this->render('game/choose.html.twig');
    }
    #[Route('/game', name: 'app_game')]
    public function play(): Response
    {
        return $this->render('game/game.html.twig');
    }
}

<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use App\Repository\CardRepository;
use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function play(CardRepository $cardRepository, Request $request): Response
    {
        $themeId = $request->query->get('theme');
        $cards = $cardRepository->findBy(['idTheme' => $themeId]);

        $images = [];
        foreach ($cards as $card) {
            $images[] = $card->getImgPath();
        }

        return $this->render('game/game.html.twig', [
            'images' => $images,
            'themeId' => $themeId,
        ]);
    }

    #[Route('/save-score', name: 'save_score', methods: ['POST'])]
    public function saveScore(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        
        $score = new Score();
        $score->setMoove($data['moves']);
        $score->setTheme($data['theme']);
        $score->setLevel(1); // Assuming level 1 for now
        $score->setTypePartie(0); // Assuming type 0 for now
        $score->setIdUser(1); // Assuming user 1 for now, you might want to get the actual user ID
        $score->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($score);
        $entityManager->flush();

        return $this->json(['success' => true, 'message' => 'Score saved successfully']);
    }
}
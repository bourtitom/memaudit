<?php

namespace App\Controller;

use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    #[Route('/save-score', name: 'save_score', methods: ['POST'])]
    public function saveScore(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $moves = $data['moves'];
        $theme = $request->query->get('theme'); // Récupération du thème depuis l'URL
        
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'User not logged in'], 401);
        }
    
        $score = new Score();
        $score->setMoove($moves);
        $score->setTheme($theme);
        $score->setLevel(1);
        $score->setTypePartie(0);
        $score->setIdUser($user->getId());
        $score->setCreatedAt(new \DateTime());
    
        $entityManager->persist($score);
        $entityManager->flush();
    
        return new JsonResponse(['status' => 'Score saved successfully'], 200);
    }
}
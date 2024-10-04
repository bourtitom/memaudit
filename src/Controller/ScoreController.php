<?php

namespace App\Controller;

use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    #[Route('/save-score', name: 'save_score', methods: ['POST'])]
    public function saveScore(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!isset($data['moves']) || !isset($data['theme'])) {
                throw new \InvalidArgumentException('Missing required data: moves or theme');
            }

            $score = new Score();
            $score->setMoove((int)$data['moves']);
            $score->setTheme((int)$data['theme']);
            $score->setLevel(1); // Assuming level 1 for now
            $score->setTypePartie(0); // Assuming type 0 for now
            $score->setIdUser(1); // Assuming user 1 for now, you might want to get the actual user ID
            $score->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($score);
            $entityManager->flush();

            return $this->json(['success' => true, 'message' => 'Score saved successfully']);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => 'Error saving score: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
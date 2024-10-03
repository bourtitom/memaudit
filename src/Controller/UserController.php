<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/update/{id}', name: 'app_user_update', methods: ['POST'])]
    public function update(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Modifier les informations de l'utilisateur
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setMail($request->request->get('mail'));

        if ($request->request->get('birthdate')) {
            $user->setBirthdate(new \DateTime($request->request->get('birthdate')));
        }

        $entityManager->flush(); // Sauvegarde dans la base de données

        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/delete/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user');
    }
}

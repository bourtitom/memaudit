<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocaleController extends AbstractController
{
    #[Route('/set-locale', name: 'app_set_locale')]
    public function setLocale(Request $request, SessionInterface $session): Response
    {
        $user = $this->getUser();
        $locale = 'fr'; // Valeur par défaut

        // Vérifie si l'utilisateur est authentifié
        if ($user instanceof \App\Entity\User) {
            // Utilise la fonction isLanguage() pour déterminer la langue
            if ($user->isLanguage()) {
                $locale = 'en'; // Anglais si language = true
            }
        }

        // Stocker la langue sélectionnée dans la session
        $session->set('_locale', $locale);

        // Vérifie si l'utilisateur a le rôle "ROLE_ADMIN"
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // Redirection vers la page de gestion pour les admins
            return new RedirectResponse($this->generateUrl('app_register'));
        } else {
            // Redirection vers la page de connexion pour les autres utilisateurs
            return new RedirectResponse($this->generateUrl('app_choose'));
        }
    }
}

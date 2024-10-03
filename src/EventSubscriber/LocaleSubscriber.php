<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $requestStack;

    // Utiliser RequestStack pour accéder à la requête courante
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // Obtenir la session via la requête
        $session = $request->getSession();
        $locale = $session->get('_locale', 'fr'); // Par défaut en français

        // Vérifier si l'utilisateur est connecté
        $user = $this->requestStack->getCurrentRequest()->getUser();
        if ($user instanceof \App\Entity\User) {
            if ($user->isLanguage()) {
                $locale = 'en'; // Anglais si la langue de l'utilisateur est définie à "anglais"
            } else {
                $locale = 'fr'; // Français sinon
            }
        }

        // Définir la locale sur la requête
        $request->setLocale($locale);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 20],
        ];
    }
}

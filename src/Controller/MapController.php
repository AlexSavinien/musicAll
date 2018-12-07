<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 * @package App\Controller
 * @Route("/home")
 */
class MapController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {

        return $this->render(
            'map/index.html.twig',
        [

        ]
        );
    }

    /**
     * @Route("/map-ajax")
     */
    public function mapAjax(Request $request)
    {
        // Je check si j'ai reçu un appel AJAX
        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();
            // Je récupère la recherche de l'utilisateur
            $research = $request->request->get('research');
            // Je stock dans une entrée d'un tableau le résultat de ma recherche d'évenement
            $tab['resultat'] = $em->getRepository(Event::class)->findEvent($research);
        }
        else
        {
            echo "Ne reçois pas d'appel AJAX";
        }

        return new JsonResponse($tab);
    }
}

<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Place;
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

    //, {id} defaults={"id" : null}, requirements={"id": "/d+"}
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
            $research = $request->query->get('research');


            /**
             * Si la recherche est nulle,
             *      alors on envois les 50 événements qui auront lieu au plus tot
             * Si non,
             *      alors on envois les 50 événements trouvé par la recherche (par date, lieu, artist, style, nom)
             */
            if (is_null($research))
            {
                $events = $em->getRepository(Event::class)->findBy([], ['eventDate'=>'asc'], 50);
            }
            else
            {
                $events = $em->getRepository(Event::class)->findEvent($research);
            }

            $tab = [];
            $i = 0;

            foreach ($events as $event) {
                $place = $event->getPlace();
                dump($event);
                $tab[$i]['lat'] = $place->getLat();
                $tab[$i]['lon'] = $place->getLon();
                $tab[$i]['place'] = $place->getName();
                $tab[$i]['name'] = (string)$event;
                $tab[$i]['artist'] = $event->getArtist();
                $i++;
            }
        }
        else
        {
            $tab['resultat'] = "Ne reçois pas d'appel AJAX";
        }

        return new JsonResponse($tab);
    }
}

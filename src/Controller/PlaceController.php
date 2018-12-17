<?php

namespace App\Controller;

use App\Entity\CommentPlace;
use App\Entity\Place;
use App\Form\CommentPlaceType;
use App\Form\PlaceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlaceController
 * @package App\Controller
 * @Route("/place")
 */
class PlaceController extends AbstractController
{
    /**
     * @param Place $place
     * @return Response
     *
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function index(Request $request, Place $place)
    {
        $em = $this->getDoctrine()->getManager();
        // =============================== FORMULAIRE ======================================
        $comment = new CommentPlace();
        $form = $this->createForm(CommentPlaceType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $comment
                    ->setPublicationDate(new \DateTime())
                    ->setAuthor($this->getUser())
                    ->setPlace($place)
                ;

                $em->persist($comment);
                $em->flush();
                $this->addFlash('success', 'Votre commentaire a bien été enregistré');
            }
            else
            {
                $this->addFlash('error', 'Le commentaire contient des erreurs');
            }
        }


        // =========================== LISTE COMMENTAIRES ==================================
        $comments = $place->getCommentsPlace();
        $events = $place->getEvents();

        return $this->render(
            'place/index.html.twig',
            [
                'place' => $place,
                'form'  => $form->createView(),
                'comments' => $comments,
                'events'   => $events
            ]
        );

    }


    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @Route("/ajouter-lieu/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function addPlace(Request $request, $id)
    {
        dump($_SERVER);
        $em = $this->getDoctrine()->getManager();
        // DEBUT - Syntaxe pour l'image dans le formulaire
        // TODO : faire les images avec julien

        if (is_null($id))
        {
            $place = new Place();
        }
        else
        {
            $repository = $em->getRepository(Place::class);
            $place = $repository->find($id);
        }

        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {

                $em->persist($place);
                $em->flush();

                $this->addFlash('success', 'Votre lieu a bien été enregistré dans la base de données');

                return $this->redirectToRoute('app_place_index', ['id'=>$place->getId()]);
            }
            else
            {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }


        return $this->render(
            'place/addPlace.html.twig',
            [
                'form'  => $form->createView(),
                'place' => $place,
            ]
        );
    }

    /**
     * @Route("/placeAjax")
     */
    public function placeAjax(Request $request)
    {
        $streetNumber = $request->request->get('streetNumber');
        $streetName = $request->request->get('streetName');
        $zipCode = $request->request->get('zipCode');

        $apiCall = file_get_contents('https://nominatim.openstreetmap.org/search?street='.$streetNumber.$streetName.'&postalcode='.$zipCode);


        return new JsonResponse($apiCall);
    }


}

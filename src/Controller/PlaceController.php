<?php

namespace App\Controller;

use App\Entity\Place;
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
    public function index(Place $place)
    {

        return $this->render(
            'place/index.html.twig',
            [
                'place' => $place
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
                'place' => $place
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

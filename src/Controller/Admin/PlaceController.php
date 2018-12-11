<?php
/**
 * Created by PhpStorm.
 * User: nicolascaux
 * Date: 11/12/2018
 * Time: 16:57
 */

namespace App\Controller\Admin;


use App\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlaceController
 * @package App\Controller\Admin
 *
 * @Route("/place")
 */
class PlaceController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Place::class);

        $places = $repository->findBy([],["name" => "asc", "owner"=>"asc"]);
dump($places);
        return $this->render(
            'admin/place/index.html.twig',
            [
                'places' => $places
            ]
        );
    }


    /**
     * @Route("/suppression/{id}")
     * @param Place $place
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Place $place)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($place);
        $em->flush();

        $this->addFlash(
            'success',
            'Le lieu est supprimé'
        );


        return $this->redirectToRoute('app_admin_place_index');
    }

}
<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller
 *
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {

        return $this->render(
            'event/index.html.twig',
            [

            ]
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/ajout-evenement/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function addEvent(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (is_null($id))
        {
            $event = new Event();
        }
        else
        {
            $event = $em->getRepository(Event::class)->find($id);
        }

        $form = $this->createForm(Event::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $em->persist($event);
                $em->flush();
                $this->redirectToRoute('app_index_index');
                $this->addFlash('success', 'Votre lieu a bien été enregistré dans la base de données');
            }
            else
            {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            '',
            [
                'form'  => $form->createView()
            ]
        );
    }

}

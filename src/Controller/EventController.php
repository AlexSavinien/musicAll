<?php

namespace App\Controller;

use App\Entity\CommentEvent;
use App\Entity\Event;
use App\Form\CommentEventType;
use App\Form\EventType;
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
     * @Route("/{id}", requirements={"id": "\d+"})
     * @param Request $request
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        // =============================== FORMULAIRE ======================================
        $comment = new CommentEvent();
        $form = $this->createForm(CommentEventType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $comment
                    ->setPublicationDate(new \DateTime())
                    ->setAuthor($this->getUser())
                    ->setEvent($event)
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
        $comments = $event->getCommentsEvent();

        return $this->render(
            'event/index.html.twig',
            [
                'event' => $event,
                'form'  => $form->createView(),
                'comments' => $comments
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

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $em->persist($event);
                $em->flush();
                $this->addFlash('success', 'Votre événement a bien été enregistré dans la base de données');

                return $this->redirectToRoute('app_event_index', ['id'=>$event->getId()]);

            }
            else
            {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'event/addEvent.html.twig',
            [
                'form'  => $form->createView(),
                'event' => $event
            ]
        );
    }

}

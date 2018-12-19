<?php

namespace App\Controller;

use App\Entity\CommentEvent;
use App\Entity\Event;
use App\Form\CommentEventType;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
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
    public function index(Request $request, Event $event)
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
        $originalImage = null;

        $em = $this->getDoctrine()->getManager();

        if (is_null($id))
        {
            $event = new Event();
        }
        else
        {
            $event = $em->getRepository(Event::class)->find($id);
            if (!is_null($event->getImage())) {

                // nom du fichier venant de la bdd
                $originalImage = $event->getImage();
                // on sette l'image avec un objet File
                // pour le traitement par le formulaire
                $event->setImage(
                    new File($this->getParameter('upload_dir') . $originalImage)
                );
            }
        }

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {

                $image = $event->getImage();

                if (!is_null($image)) {
//                    dump($image);
                    // TODO : S'occuper la prise en charge image
                    $filename = uniqid() . '.' . $image->guessExtension();

                    // équivalent de move_uploaded_file()
                    $image->move(
                    // répertoire de destination
                    // cf le parametre upload_dir dans config/services.yaml
                        $this->getParameter('upload_dir'),
                        // nom du fichier
                        $filename
                    );

                    // on sette l'attribut image de l'article avec le nom
                    // de l'image pour enregistrement en bdd
                    $event->setImage($filename);

                    // en modification, on supprime l'ancienne image s'il y en a une
                    if (!is_null($originalImage)) {
                        unlink($this->getParameter('upload_dir') . $originalImage);
                    }
                } else {
                    // sans upload, pour la modification, on sette l'attribut
                    // image avec le nom de l'ancienne image
                    $event->setImage($originalImage);
                }


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
                'event' => $event,
                'original_image' => $originalImage
            ]
        );
    }

}

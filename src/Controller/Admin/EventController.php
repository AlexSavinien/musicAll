<?php
/**
 * Created by PhpStorm.
 * User: nicolascaux
 * Date: 13/12/2018
 * Time: 12:24
 */

namespace App\Controller\Admin;


use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller\Admin
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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Event::class);

        $events = $repository->findBy([],["eventDate" => 'asc', 'name' => 'asc']);

        return $this->render(
            'admin/event/index.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/suppression/{id}")
     */
    public function delete(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        $this->addFlash(
            'success',
            'L\'événement est supprimé'
        );

        return $this->redirectToRoute('app_admin_event_index');
    }
}
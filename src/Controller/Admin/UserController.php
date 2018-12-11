<?php
/**
 * Created by PhpStorm.
 * User: nicolascaux
 * Date: 11/12/2018
 * Time: 09:58
 */

namespace App\Controller\Admin;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller\Admin
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(User::class);

        $users = $repository->findBy([], ['role'=>'asc', 'lastname' => 'asc']);

        return $this->render(
            'admin/user/index.html.twig',
            [
                'users' => $users
            ]
        );
    }

    /**
     * @Route("/suppression/{id}")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(User $user)
    {
        $em = $this->getDoctrine()->getManager();

            $em->remove($user);
            $em->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur est supprimé'
            );


        return $this->redirectToRoute('app_admin_user_index');
    }

    /**
     * @Route("/statut/{id}")
     */
    public function statut(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        if ( $user->getRole() == 'ROLE_ADMIN' )
        {
            $user->setRole('ROLE_USER');
        }

        elseif ($user->getRole() == 'ROLE_USER')

        {
            $user->setRole('ROLE_ADMIN');
        }

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_admin_user_index');
    }


}













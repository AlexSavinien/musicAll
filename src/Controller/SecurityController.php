<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/index")
     */
    public function index()
    {
        return $this->render('security/index.html.twig');
    }


    /**
     * @Route("/inscription")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {

            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ( $form->isSubmitted() ){
                if ( $form->isValid() ){
                    $password = $passwordEncoder->encodePassword(
                        $user,
                        $user->getPlainPassword()
                    );

                    $user->setPassword($password);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Votre compte est créé');

                    $this->redirectToRoute('app_security_login');

                }
            }

            return $this->render(
                'security/register.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );

    }




    /**
     * @Route("/connexion")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // on traite le formulaire par la fonction security
        $error  = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        dump($error);

        if ( !empty($error) ){
            $this->addFlash("error", 'Identifiant incorrecte');
        }

        if(!is_null($this->getUser()))
        {
            $this->redirectToRoute('app_security_index');
        }

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername
            ]
        );
    }

}

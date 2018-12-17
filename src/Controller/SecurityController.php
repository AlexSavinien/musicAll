<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("/security")
 */
class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription/{id}", defaults={"id": null}, requirements={"id" :"\d+"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(
        $id,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {

        $originalImage = null;
//        dump($user);
        if ( is_null($id) ){
            $user = new User();
        }
        else {
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);
            if (!is_null($user->getImage())) {

                // nom du fichier venant de la bdd
                $originalImage = $user->getImage();
                // on sette l'image avec un objet File
                // pour le traitement par le formulaire
                $user->setImage(
                    new File($this->getParameter('upload_dir') . $originalImage)
                );
            }
        }

            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ( $form->isSubmitted() ){
                if ( $form->isValid() ){

                    $image = $user->getImage();
                    if (!is_null($image)) {
                        // non de l'image dans notre application
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
                        $user->setImage($filename);

                        // en modification, on supprime l'ancienne image s'il y en a une
                        if (!is_null($originalImage)) {
                            unlink($this->getParameter('upload_dir') . $originalImage);
                        }
                    } else {
                        // sans upload, pour la modification, on sette l'attribut
                        // image avec le nom de l'ancienne image
                        $user->setImage($originalImage);
                    }

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
            $this->redirectToRoute('app_map_index');
        }

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername
            ]
        );
    }

}

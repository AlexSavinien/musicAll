<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 * @Route("/")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('map/index.html.twig', [

        ]);
    }

    /**
     * @Route("/mentions-legales")
     */
    public function legal()
    {
        $mentionLegal = "Mentions Légales et protections des données RGPD
        Les sites www.musicall.fr est édité et dirigés par:
        Alexandre Savinien, Stéphane Bouillot, Nicolas Caux et Hervé Gibet
        BP N°40065
        France
        email
        Le responsable publication est Alexandre Savinien
        Tél. : 00 00 00 00

        Le site www.musicall.com est hébergé par: O2switch.fr  (conforme à la RGPD) => Voir les conditions de la politique protection des données du serveur O2switch en cliquant ici

        Responsable de la protections de vos données : développement-personnel-club.com et  de developpement-personnel-club-boutique.com
        Loi CNIL informatique et libertés
        Conformément à la loi « Informatique et Libertés » du 6 janvier 1978, ce site a fait l’objet d’une déclaration à la CNIL – récépissé de déclaration n° 1404635
        Conformément à la loi «Informatique et Libertés » du 6 janvier 1978, les personnes ayant fourni des informations personnelles peuvent exercer leurs droits d’accès et de modification sur ces données, en envoyant un courrier électronique à l’adresse suivante .  De plus, aucune information personnelle n’est collectée à l’insu des utilisateurs du site, ni cédée à des tiers, ni utilisée à des fins personnelles sans votre accord. 
        Si vous vous inscrivez à ce club, vous acceptez de recevoir la newsletter via le service SG-autorepondeur (conforme aux règles et législation en vigueur RGPD).
        Nous vous informons que lorsque vous vous inscrivez à notre newsletter intitulée : cours gratuits de développement personne et 9 cadeaux de bienvenue, vous comprenez qu’en vous abonnant, vous choisissez explicitement de recevoir la newsletter et que vous pouvez facilement et à tout moment vous désinscrire. « En soumettant ce, vous acceptez que mes informations soient utilisées exclusivement dans le cadre de ma demande et de la relation commerciale éthique et personnalisée qui pourrait en découler si vous le souhaitez. »
        Vos données (email + IP) sont systématiquement supprimées dans les 48 heures après réception  :
        1. à votre demande par  mail sur ce lien de contact 
        2. si vous n’avez pas ouvert un email de notre part après 1 année après votre inscription à notre newsletter via SG-autorépondeur
        Exigence de confirmation en double optin : Précisions pour vous assurer que votre demande d’information ne sera jamais partagées ou issue d’un envoi non sollicité ; notre politique d’envoi d’email est associé à l’exigence d’un double optin. Ce qui signifie que suite à votre inscription à nos formulaires (email + prénom), vous recevrez suite à cela une demande de confirmation de votre part afin de savoir si c’est bien vous (et uniquement vous) qui nous avez sollicité pour l’envoi de cet email.
        Contrôle de vos données
        Vous avez le plein contrôle de vos donnés durant votre inscription à différentes newsletter de developpement-personnel-club.com, developper-sa-memoire.com, clefs-reves.com, gerer-le-stress.com, ou achats sur developpement-personnel-club-boutique.com.
        Un tutoriel en image vous explique comment accéder et contrôler vos données personnels lorsque vous recevez un email de notre part.";

        return $this->render(
            'index/legal.html.twig',
        [
            'mention' => $mentionLegal
        ]
        );
    }

    /**
     * @Route("/contact")
     */
    public function contact()
    {

        return $this->render(
            'index/contact.html.twig',
            [

            ]
        );
    }
}

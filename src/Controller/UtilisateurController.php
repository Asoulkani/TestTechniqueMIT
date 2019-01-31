<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Zend\Code\Scanner\Util;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findAll();
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    /**
     * @Route("/create",name="create")
     * @Route("/update/{id}",name="update")
     */
    public function create(Utilisateur $utilisateur = null,Request $request,ObjectManager $manager)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $action = "update";
            if (!$utilisateur) {
                $utilisateur = new Utilisateur();
                $action = "new";
            }

            $form = $this->createFormBuilder($utilisateur)
                ->add('nom', null, [
                    'attr' => [
                        'placeholder' => 'Entrer le nom'
                    ]
                ])
                ->add('prenom', null, [
                    'attr' => [
                        'placeholder' => 'Entrer le prenom'
                    ]
                ])
                ->add('dateNaissance')
                ->add('adresse', null, [
                    'attr' => [
                        'placeholder' => 'Entrer l adresse'
                    ]
                ])
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($utilisateur);
                $manager->flush();
                return $this->redirectToRoute('home');
            }

            return $this->render('utilisateur/create.html.twig', [
                "formUtilisateur" => $form->createView(),
                "action" => $action
            ]);
        }
        else
            return $this->redirectToRoute('cnx');
    }

    /**
     * @Route("/delete/{id}",name="delete")
     */
    public function delete(Utilisateur $utilisateur,ObjectManager $manager)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($utilisateur) {
                $manager->remove($utilisateur);
                $manager->flush();
            }
            return $this->redirectToRoute('home');
        }
        else
            return $this->redirectToRoute('cnx');
    }

    /**
     * @Route("/utilisateur/{id}",name="show")
     */
    public function show(Utilisateur $utilisateur)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('utilisateur/show.html.twig',[
                'utilisateur' => $utilisateur
            ]);
        }
        else
            return $this->redirectToRoute('cnx');
    }

}

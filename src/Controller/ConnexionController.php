<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ConnexionController extends AbstractController
{
    /**
     * @Route("/inscription",name="inscription")
     */
    public function inscription(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {
        $admin = new Admin();
        $form = $this->createForm(RegistrationType::class,$admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($admin,$admin->getPassword());
            $admin->setPassword($hash);
            $manager->persist($admin);
            $manager->flush();
            return $this->redirectToRoute('cnx');
        }

        return $this->render('connexion/inscription.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cnx",name="cnx")
     */
    public function connexion(Request $request)
    {
        return $this->render('connexion/connexion.html.twig');
    }
    /**
     * @Route("/dcnx",name="dcnx")
     */
    public function deconnexion(){}
}

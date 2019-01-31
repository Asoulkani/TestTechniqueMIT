<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1;$i <= 10 ;$i++)
        {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom("nomUtilisateur$i")
                ->setAdresse("addr$i")
                ->setDateNaissance(new \DateTime())
                ->setPrenom("prenom$i");
            $manager->persist($utilisateur);
        }
        $manager->flush();
    }
    /**
     * @Route("/add",name="add")
     * @Route("/udapte/{id}",name="update")
     */
    public function add_update(Utilisateur $utilisateur,ObjectManager $manager)
    {

    }
}

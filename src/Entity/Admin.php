<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 *  @UniqueEntity("pseudo",message="pseudo existe deja !")
 */
class Admin implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = "8",
     *      minMessage = "Mot de passe doit être d'un minimum 8 caracteres"
     * )
     * @Assert\EqualTo(propertyPath="confirmationDeMotDePasse",message="mot de passe different que la confirmation")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="confirmationDeMotDePasse")
     */
    private $confirmationDeMotDePasse;

    public function getConfirmationDeMotDePasse(): ?string
    {
        return $this->confirmationDeMotDePasse;
    }

    public function setConfirmationDeMotDePasse(string $confirmationDeMotDePasse): self
    {
        $this->confirmationDeMotDePasse = $confirmationDeMotDePasse;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function getUsername()
    {
        return $this->getPseudo();
    }
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}

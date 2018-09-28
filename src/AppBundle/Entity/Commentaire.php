<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostInterface;
use AppBundle\Entity\Actualite as Actualite;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire extends Post implements PostInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="Actualite",inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=true,onDelete="CASCADE")
     */
    private $actualite;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActualite()
    {
        return $this->actualite;
    }

    /**
     * @param mixed $actualite
     *
     * @return self
     */
    public function setActualite($actualite)
    {
        $this->actualite = $actualite;

        return $this;
    }

    public function createPost($entityManager,$entity,$actualite=null){
        $entity->setActualite($actualite);
        $entity->setCreatedAt(new \DateTime());
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    public function deletePost($entityManager,$entity){
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}


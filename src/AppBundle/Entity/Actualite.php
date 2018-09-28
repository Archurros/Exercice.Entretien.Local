<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Actualite
 *
 * @ORM\Table(name="actualite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActualiteRepository")
 */
class Actualite extends Post implements PostInterface
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="number_comm", type="integer")
     */
    private $numberComm = 0;

    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="actualite")
     */
    private $commentaires;


    public function __construct() {
        $this->commentaires = new ArrayCollection();
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberComm()
    {
        return $this->numberComm;
    }

    /**
     * @param int $numberComm
     *
     * @return self
     */
    public function setNumberComm($numberComm)
    {
        $this->numberComm = $numberComm;

        return $this;
    }

    public function getCommentaires(){
        return $this->commentaires;
    }

    public function createPost($entityManager,$entity,$idActualite=null){
        $entity->setCreatedAt(new \DateTime());
        $entity->setNumberComm(0);
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    public function deletePost($entityManager,$entity){
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
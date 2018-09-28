<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

interface PostInterface{

    public function createPost($entityManager,$entity,$idActualite=null);
    public function deletePost($entityManager,$entity);

}
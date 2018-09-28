<?php
namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Entity\Commentaire as Commentaire;

class CommentaireListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        // only act on some "Product" entity
        if ($entity instanceof Commentaire) {
            $nbCommentaires = $entity->getActualite()->getNumberComm()+1;
            $entity->getActualite()->setNumberComm($nbCommentaires);
            $entityManager->flush();
        }
    }
}
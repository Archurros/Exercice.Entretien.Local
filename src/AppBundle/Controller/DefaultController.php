<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Commentaire as Commentaire;
use AppBundle\Entity\Actualite as Actualite;
use AppBundle\Form\CommentaireType as CommentaireType;
use AppBundle\Form\ActualiteType as ActualiteType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actus = $em->getRepository('AppBundle:Actualite')->findAll();
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $actualite = $form->getData();
            $actualite->createPost($em,$actualite);
            // Redirection afin d'éviter le "re-posting"
            return $this->redirect($this->generateUrl('homepage'));
        }
            
        return $this->render('default/index.html.twig', array(
            'actualites' => $actus,
            'form'       => $form->createView() ));
    }

    /**
     * @Route("/actualite/{id}", name="showActualite")
     */
    public function showActualiteAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();
        $actu = $em->getRepository('AppBundle:Actualite')->findOneById($id);
        //Creation du formulaire pour les commentaires.
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();
            $commentaire->createPost($em,$commentaire,$actu);
            // Redirection afin d'éviter le "re-posting"
            return $this->redirect($this->generateUrl('showActualite',array("id"=>$id)));
        }
        return $this->render('actualites/show.html.twig', array(
            'actualite' => $actu,
            'form'      => $form->createView() ));
    }
    /**
     * @Route("/actualite/{id}/delete", name="deleteActualite")
     */
    public function deleteActualiteAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();
        $actu = $em->getRepository('AppBundle:Actualite')->findOneById($id);
    
        $actu->deletePost($em,$actu);
        // Redirection afin d'éviter le "re-posting"
        return $this->redirect($this->generateUrl('homepage'));
        
    }

    /**
     * @Route("/commentaire/{id}/delete", name="deleteCommentaire")
     */
    public function deleteCommentaireAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('AppBundle:Commentaire')->findOneById($id);
    
        $commentaire->deletePost($em,$commentaire);
        $nbCommentaires = $commentaire->getActualite()->getNumberComm()-1;
        $commentaire->getActualite()->setNumberComm($nbCommentaires);
        $em->flush();
        // Redirection afin d'éviter le "re-posting"
        return $this->redirect($this->generateUrl('showActualite',array("id"=>$commentaire->getActualite()->getId())));
        
    }
}

<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('createdBy',TextType::class,array('label' => 'Votre nom d\'utilisateur',
                        'attr' => array(
                            'class' =>  'form-control'), ))
                ->add('message',TextareaType::class,array('label' => 'Votre message',
                        'attr' => array(
                            'class' =>  'tiny-textarea'), ))
                ->add('publier', SubmitType::class, array(
                        'attr' => array(
                            'class' => 'btn btn-primary'), ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commentaire';
    }


}

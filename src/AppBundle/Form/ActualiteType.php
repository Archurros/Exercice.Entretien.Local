<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActualiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class,array('label' => 'Titre de l\'article',
                        'attr' => array(
                            'class' =>  'form-control'), ))
                ->add('createdBy',TextType::class,array('label' => 'Publiée par ',
                        'attr' => array(
                            'class' =>  'form-control'), ))
                ->add('description',TextareaType::class,array('label' => 'Description',
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
        return 'appbundle_actualite';
    }


}

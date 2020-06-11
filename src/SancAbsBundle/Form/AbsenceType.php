<?php

namespace SancAbsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eleve',EntityType::class,
                array('class'=>'ProfilBundle\Entity\Profileleve',
                    'choice_label'=>'nom',
                    'disabled'   => false
                ) )
            ->add('classe',EntityType::class,
                array('class'=>'SancAbsBundle\Entity\Classe',
                    'choice_label'=>'nom',
                    'disabled'   => false
                ) )
            ->add('matiere',EntityType::class,
                array('class'=>'SancAbsBundle\Entity\Matiere',
                    'choice_label'=>'nom',
                    'disabled'   => false
                ) )
            //    ->add('Ajouter', SubmitType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SancAbsBundle\Entity\Absence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sancabsbundle_absence';
    }


}

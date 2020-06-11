<?php

namespace ProfilBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileleveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add('adress')
            ->add('datenaiss')
            ->add('tel')
            ->add('classe',EntityType::class,
                array('class'=>'SancAbsBundle\Entity\Classe',
                    'choice_label'=>'nom',
                    'disabled'   => false
                ) )
            ->add('branche', ChoiceType::class, [
                'choices'  => [
                    'Math' => 'Math',
                    'Info' => 'Prog',
                    'Science' => 'Science',
                    'Lettre' => 'Lettre',
                    'Sport' => 'Sport',
                ],
            ])

            ->add('parent',EntityType::class,
                array('class'=>'ProfilBundle\Entity\Profilparent',
                    'choice_label'=>'nom',
                    'disabled'   => false
                ) )
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProfilBundle\Entity\Profileleve'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'profilbundle_profileleve';
    }


}

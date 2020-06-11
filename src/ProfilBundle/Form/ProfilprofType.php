<?php

namespace ProfilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilprofType extends AbstractType
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
            ->add('cin')
            ->add('specialite', ChoiceType::class, [
                'choices'  => [
                    'Math' => 'Math',
                    'Info' => 'Prog',
                    'Science' => 'Science',
                    'Lettre' => 'Lettre',
                    'Sport' => 'Sport',
                ],
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProfilBundle\Entity\Profilprof'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'profilbundle_profilprof';
    }


}

<?php

namespace SancAbsBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsenceemployeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('employe',EntityType::class,
                array('class'=>'ProfilBundle\Entity\Profilprof',
                    'choice_label'=>'nom',
                    'disabled'   => false
                ) )
            ->add('nbrheure')
            ->add('captcha', CaptchaType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SancAbsBundle\Entity\Absenceemploye'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sancabsbundle_absenceemploye';
    }


}

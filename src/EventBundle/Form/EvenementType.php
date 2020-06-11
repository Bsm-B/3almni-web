<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use blackknight467\StarRatingBundle\Form\RatingType;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image',FileType::class,array('data_class'=>array( 'class'=>'form-control col-md-6','style'=>'margin-bottom:15px;')))
            ->add('image', FileType::class, array('data_class' => null,'required' => false))
            ->add('nom')
            ->add('description')
            ->add('date')
            ->add('lieu')
            ->add('organizateur')
            ->add('rating', RatingType::class, ['label' => 'Rating']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_evenement';
    }


}

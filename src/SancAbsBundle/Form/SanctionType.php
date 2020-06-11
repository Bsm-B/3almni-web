<?php

namespace SancAbsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class SanctionType extends AbstractType
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
            ->add('nature', ChoiceType::class, [
                'choices'  => [
                    'Convocation des parents' => 'Convocation des parents',
                    'Avertissement' => 'Avertissement',
                    'Expulsion' => 'Expulsion',
                ],
            ])
            ->add('commentaire', TextareaType::class, array(
                'label' => 'Commentaire',
                'attr' => array('class' => 'myclass')
            ));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SancAbsBundle\Entity\Sanction'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sancabsbundle_sanction';
    }


}

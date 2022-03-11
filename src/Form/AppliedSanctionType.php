<?php

namespace App\Form;

use App\Entity\AppliedSanction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppliedSanctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sanctionType', ChoiceType::class, [
                'label' => 'Type de sanction',
                'placeholder'  =>    '---choisir le type---',
                'choices' =>    ['Absence'  =>  'absence','Retard'    =>  'retard'],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('amount')
            ->add('meeting')
            ->add('member')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppliedSanction::class,
        ]);
    }
}

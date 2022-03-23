<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Assistance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AssistanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('distributedDate', DateType::class, ['label' => 'Date octroi',
            'widget' => 'single_text',
            'attr' => [
                'placeholder' => 'Date d\'assistance',
                ]
            ])
            ->add('amount', TextType::class, ['label' =>  'Montant de l\'assistance'])
            ->add('reason', TextareaType::class, ['label' =>  'Motif d\'assistance'])
            ->add('beneficiary', EntityType::class, [
                'label' => 'Bénéficiaire',
                'class' => User::class,
                'expanded' => false,
                'multiple' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assistance::class,
        ]);
    }
}

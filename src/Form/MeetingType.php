<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('meetingAt', DateType::class, [
                'label' =>  'Date rencontre',
                'widget'    =>  'single_text',
                'attr'  =>  [
                    'placeholder'   =>  'Date de rencontre'
                ]
            ])
            ->add('status', TextType::class, [
                'label' =>  'Status',
                'attr'   =>  [
                    'placeholder' => 'Etat rencontre'
                ]
            ])
            ->add('hostOne', EntityType::class, [
                'label' => 'Hôte 1',
                'class' => User::class,
                'expanded' => false,
                'multiple' => false
                ])
            ->add('hostTwo', EntityType::class, [
                'label' => 'Hôte 2',
                'class' => User::class,
                'expanded' => false,
                'multiple' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}

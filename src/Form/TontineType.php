<?php

namespace App\Form;

use App\Entity\Tontine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TontineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Dénomination de la tontine',
                'attr' => [
                    'placeholder' => 'Appelation complète',
                ],
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date à la quelle la totine a vu le jour',
                ],
            ])
            ->add('addressSiegeSocial', TextType::class, [
                'label' => 'Adresse Siège Social',
                'attr' => [
                    'placeholder' => 'Ville de la tontine',
                ],
            ])
            ->add('currency', TextType::class, [
                'label' => 'Devise',
                'attr' => [
                    'placeholder' => 'Symbole monétaire utilisé',
                ],
            ])
            ->add('slogan', TextType::class, [
                'label' => 'Slogan',
                'attr' => [
                    'placeholder' => "Slogan s'il y en a",
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Une brève description',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type tontine',
                'choices' => ['Association' => 'Association', 'Tontine' => 'Tontine'],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tontine::class,
        ]);
    }
}

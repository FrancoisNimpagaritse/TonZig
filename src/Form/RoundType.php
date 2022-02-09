<?php

namespace App\Form;

use App\Entity\Round;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RoundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roundNumber', IntegerType::class, [
                'label' =>  'N° du round'
                ])
            ->add('roundStartDate', DateType::class, [
                'label' =>  'Date début',
                'widget'    =>  'single_text',
                'attr'  =>  [
                    'placeholder'   =>  'Date de la 1ère rencontre'
                ]
            ])
            ->add('monthlyCotisation', TextType::class, [
                'label' =>  'Montant cotisation',
                'attr'   =>  [
                    'placeholder' => 'Montant de cotisation mensuelle'
                ]
            ])
            ->add('monthlyCaisseSociale', TextType::class, [
                'label' =>  'Montant Caisse sociale',
                'attr'   =>  [
                    'placeholder' => 'Montant mensuel de caisse sociale'
                ]
            ])
            ->add('loanMonthsDuration', TextType::class, [
                'label' =>  'Durée de crédit (en mois)',
                'attr'   =>  [
                    'placeholder' => 'Durée de remboursement'
                ]
            ])
            ->add('loanMonthlyInterestPercentage', TextType::class, [
                'label' =>  "Taux d'intérêts (%)",
                'attr'   =>  [
                    'placeholder' => "Le taux d'intérêts"
                ]
            ])
            ->add('loanPrincipalGracePeriod', TextType::class, [
                'label' =>  'Période de grâce principal',
                'attr'   =>  [
                    'placeholder' => 'Mois avant de payer le principal'
                ]
            ])
            ->add('loanInterestGracePeriod', TextType::class, [
                'label' =>  'Période de grâce intérêts',
                'attr'   =>  [
                    'placeholder' => 'Mois avant de payer intérêts'
                ]
            ])
            ->add('principalLatePenalityPercentage', TextType::class, [
                'label' =>  'Pénalité retard principal (%)',
                'attr'   =>  [
                    'placeholder' => '% pénalité'
                ]
            ])
            ->add('interestLatePenalityPercentage', TextType::class, [
                'label' =>  'Pénalité retard intérêt (%)',
                'attr'   =>  [
                    'placeholder' => '% pénalité'
                ]
            ])
            ->add('meetingLatePenalityAmount', TextType::class, [
                'label' =>  'Pénalité retard',
                'attr'   =>  [
                    'placeholder' => 'Montant pénalité'
                ]
            ])
            ->add('meetingAbsencePenalityAmount', TextType::class, [
                'label' =>  'Pénalité abscence',
                'attr'   =>  [
                    'placeholder' => 'Montant pénalité'
                ]
            ])
            ->add('meetingFrequency', TextType::class, [
                'label' =>  'Fréq rencontres',
                'attr'   =>  [
                    'placeholder' => 'Jours entre rencontres'
                ]
            ])
            ->add('meetingStartHour', TextType::class, [
                'label' =>  'Heure des réunions',
                'attr'   =>  [
                    'placeholder' => 'heure debut (ex: 15:00)'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Etat du round',
                'choices' => ['Encours' => 'open', 'Clôturé' => 'closed'],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('totalMeetings', TextType::class, [
                'label' =>  'Nbre des rencontres',
                'attr'   =>  [
                    'placeholder' => 'Nombre des rencontres'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Round::class,
        ]);
    }
}

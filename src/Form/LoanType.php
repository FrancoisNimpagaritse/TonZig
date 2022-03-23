<?php

namespace App\Form;

use App\Entity\Loan;
use App\Entity\Meeting;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('disbursedAt', DateType::class, [
                'label' => 'Date octroi',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date d\'octroi',
                ],
            ])
            ->add('amount', TextType::class, [
                'label' =>  'Montant du crédit'
            ])
            ->add('member', EntityType::class, [
                'label' => 'Bénéficiaire',
                'class' => User::class,
                'expanded' => false,
                'multiple' => false,
                ])
            ->add('duration', IntegerType::class, [
                'data'  =>  6,
                'label' =>  'Durée du crédit(en mois)'
            ])
            ->add('meeting', EntityType::class, [
                'label' => 'Rencontre',
                'class' => Meeting::class,
                'expanded' => false,
                'multiple' => false,
                ])
            ->add('status', ChoiceType::class, [
                'label' => 'Etat',
                'choices' => ['Encours' => 'encours', 'Payé' => 'payé'],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}

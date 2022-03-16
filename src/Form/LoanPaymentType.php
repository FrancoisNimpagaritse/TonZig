<?php

namespace App\Form;

use App\Entity\LoanPayment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoanPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PaidDate', DateType::class, [
                'label' =>  'Payé le',
                'widget' => 'single_text'
            ])
            ->add('principal', TextType::class, [
                'label' =>  'Montant crédit'
            ])
            ->add('interest', TextType::class, [
                'label' =>  'Montant Intérêts'
            ])
            ->add('penality', TextType::class, [
                'label' =>  'Montant pénalités'
            ])
            ->add('loan',null, [
            'label' =>  'Crédit à payer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoanPayment::class,
        ]);
    }
}

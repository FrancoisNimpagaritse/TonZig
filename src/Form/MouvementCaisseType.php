<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\MouvementCaisse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MouvementCaisseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('transactionDate', DateType::class, [
                'label' => 'Date opération',
                'widget' => 'single_text',
            ])
            ->add('description', TextType::class, [
                'label' =>  'Description'
            ])
            ->add('type', ChoiceType::class, [
                'label' =>  'Type mouvement',
                'placeholder'  =>    '--choisir type---',
                'choices' =>    ['Entrée' => 'entrée', 'Sortie' => 'sortie'],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('amount', TextType::class, [
                'label' =>  'Montant de l\'opération'
            ])
            ->add('originCode', TextType::class, [
                'label' => 'Nature',
                'data'  =>  'Tx_Man'
            ])
            ->add('account', EntityType::class, [
                'label' => 'Compte',
                'class' => Account::class,
                'expanded' => false,
                'multiple' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MouvementCaisse::class,
        ]);
    }
}

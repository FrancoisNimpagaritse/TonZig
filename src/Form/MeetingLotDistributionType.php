<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\MeetingLotDistribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingLotDistributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount')
            ->add('beneficiaire1', EntityType::class, [
                'label' => 'Bénéficiaire n° 1',
                'class' => User::class,
                'mapped'    => false
                ])
                ->add('beneficiaire2', EntityType::class, [
                    'label' => 'Bénéficiaire n° 2',
                    'class' => User::class,
                    'mapped'    => false
                    ])
            ->add('beneficiaires', TextType::class,['disabled' => true])
            ->add('meeting')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeetingLotDistribution::class,
        ]);
    }
}

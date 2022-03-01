<?php

namespace App\Form\Filter;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roleUser', ChoiceType::class, [
                'label' => 'Fonction',
                'choices' => [
                    'Utilisateur'=> '[]',
                    'Admin' => User::ROLE_ADMIN,
                ],
                'required' => false,
                'placeholder' => 'Toutes',
            ])
             ->add('ordreNom', ChoiceType::class, [
                'label' => 'Ordre par nom',
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                ],
                'required' => false,
            ])
             ->add('ordrePrenom', ChoiceType::class, [
                'label' => 'Ordre par prénom',
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['row_attr']['route'] == "user_new") {
            $required = true;
        }
        else{
            $required = false;
        }
        $builder
            ->add('email', TextType::class,[
                'label' => 'E-mail de l\'utilisateur',
                'required' => true,
            ])
            ->add('roles', CollectionType::class, [
                'label' => 'Fonction de l\'utilisateur',
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices' => [
                        'Utilisateur'=> '[]',
                        'Admin' => User::ROLE_ADMIN,
                    ],
                    'required' => false,
                    'placeholder' => 'Veuillez choisir un rôle',
                ],
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe de l\'utilisateur',
                'required' => $required,
            ])
            ->add('lastnameUser', TextType::class,[
                'label' => 'Nom de l\'utilisateur',
                'required' => true,
            ])
            ->add('firstnameUser', TextType::class,[
                'label' => 'Prénom de l\'utilisateur',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['id' => 'userForm']
        ]);
    }
}

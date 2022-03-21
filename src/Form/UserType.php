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

        $builder
            ->add('email', TextType::class,[
                'label' => 'E-mail de l\'utilisateur',
                'required' => true,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Fonction de l\'utilisateur',
                'choices' => [
                    'Utilisateur'=> User::ROLE_USER,
                    'Gestionnaire' => User::ROLE_WEBMASTER,
                    'Admin' => User::ROLE_ADMIN,
                ],
                'required' => false,
                'multiple' => true,
                'placeholder' => 'Veuillez choisir un rôle',

            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe de l\'utilisateur',
                'required' => $options['password_required'],
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
            'attr' => ['id' => 'userForm'],
            'password_required' => true,
        ]);
    }
}

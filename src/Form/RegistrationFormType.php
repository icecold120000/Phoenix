<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Email',
                'required' => true,
            ])
            ->add('firstnameUser', TextType::class,[
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('lastnameUser', TextType::class,[
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Votre mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe'],
                'invalid_message' => 'Vos mots de passe doivent correspondre !',
                'help' => 'Votre mot de passe doit comporter au moins 6 caractères.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre mot de passe !',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Vos mot de passe doit comporter au moins 6 caractères !',
                        'max' => 4096,
                        'maxMessage' => 'Vos mot de passe doit être limité à 4096 caractères !',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['id' => 'registerForm']
        ]);
    }
}

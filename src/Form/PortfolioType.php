<?php

namespace App\Form;

use App\Entity\Portfolio;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('namePortfolio', TextType::class,[
                'label' => 'Nom du portfolio',
                'required' => true,
            ])
            ->add('responsablePortfolio', EntityType::class,[
                    'label' => 'Chef de l\'équipe',
                    'class' => User::class,
                    'query_builder' => function (UserRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => function (?User $user) {
                        return $user ? $user->getFirstnameUser().' '. $user->getLastnameUser() : '';
                    },
                    'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portfolio::class,
            'attr' => ['id' => 'portfolioForm']
        ]);
    }
}

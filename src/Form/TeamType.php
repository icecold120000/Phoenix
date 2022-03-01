<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamName', TextType::class,[
                'label' => 'Nom de l\'équipe',
                'required' => true,
            ])
            ->add('teamLeader', EntityType::class,[
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
            ->add('team', EntityType::class,[
                'label' => 'Équipe parente',
                'class' => Team::class,
                'query_builder' => function (TeamRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.id', 'ASC');
                },
                'choice_label' => 'teamName',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
            'attr' => ['id' => 'teamForm'],
        ]);
    }
}

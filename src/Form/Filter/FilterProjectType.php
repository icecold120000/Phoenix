<?php

namespace App\Form\Filter;

use App\Entity\Status;
use App\Repository\StatusRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('orderProject', ChoiceType::class, [
                'label' => 'Ordre par',
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                ],
                'required' => false,
                'empty_data' => 'DESC',
            ])
            ->add('searchProject', TextType::class,[
                'label' => 'Rechercher un projet',
                'required' => false,
            ])
            ->add('statusProject', EntityType::class,[
                'label' => 'Statut',
                'class' => Status::class,
                'query_builder' => function (StatusRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id');
                },
                'choice_label' => 'name',
                'choice_value' => function (?Status $status) {
                    return $status ? $status->getId() : '';
                },
                'required' => false,
                'placeholder' => 'Tous',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

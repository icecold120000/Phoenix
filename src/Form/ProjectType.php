<?php

namespace App\Form;

use App\Entity\Budget;
use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Team;
use App\Repository\BudgetRepository;
use App\Repository\PortfolioRepository;
use App\Repository\StatusRepository;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameProject', TextType::class,[
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('codeProject', TextType::class,[
                'label' => 'Code',
                'required' => true,
            ])
            ->add('descriptionProject', TextareaType::class,[
                'label' => 'Description',
                'required' => true,
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'Date du début',
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'invalid_message' => 'Votre saisie n\'est pas une date et heure !',
            ])
            ->add('endedAt', DateType::class, [
                'label' => 'Date de fin',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'invalid_message' => 'Votre saisie n\'est pas une date et heure !',
            ])
            ->add('status', EntityType::class,[
                'label' => 'Statut du projet',
                'class' => Status::class,
                'query_builder' => function (StatusRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('portfolio', EntityType::class,[
                'label' => 'Portfolio assigné',
                'class' => Portfolio::class,
                'query_builder' => function (PortfolioRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.namePortfolio', 'ASC');
                },
                'choice_label' => 'namePortfolio',
                'required' => false,
            ])
            ->add('productionTeam', EntityType::class,[
                'label' => 'Choisir l\'équipe de production',
                'class' => Team::class,
                'mapped' => false,
                'query_builder' => function (TeamRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.id', 'ASC');
                },
                'choice_label' => 'teamName',
                'required' => false,
            ])
            ->add('teamClient', EntityType::class,[
                'label' => 'Choisir l\'équipe client',
                'class' => Team::class,
                'mapped' =>false,
                'query_builder' => function (TeamRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.id', 'ASC');
                },
                'choice_label' => 'teamName',
                'required' => false,
            ])
            ->add('projectBudget', EntityType::class,[
                'label' => 'Assigner un budget',
                'class' => Budget::class,
                'mapped' =>false,
                'query_builder' => function (BudgetRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.id', 'ASC');
                },
                'choice_label' => 'nameBudget',
                'required' => false,
            ])
            ->add('archiveProject', ChoiceType::class, [
                'label' => 'Archivé',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'required' => true,
                'empty_data' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'attr' => ['id' => 'projectForm'],
        ]);
    }
}

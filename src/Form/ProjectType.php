<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Status;
use App\Repository\StatusRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('descriptionProject', TextareaType::class,[
                'label' => 'Description',
                'required' => true,
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'Date du début',
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'help' => ' Format : JJ/MM/AAAA',
                'invalid_message' => 'Votre saisie n\'est pas une date et heure !',
            ])
            ->add('endedAt', DateType::class, [
                'label' => 'Date de fin',
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'help' => ' Format : JJ/MM/AAAA',
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

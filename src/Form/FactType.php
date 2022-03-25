<?php

namespace App\Form;

use App\Entity\Fact;
use App\Entity\Milestone;
use App\Repository\MilestoneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class FactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateFact', DateType::class, [
                'label' => 'Date du fait',
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'invalid_message' => 'Votre saisie n\'est pas une date !',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir une raison valable!'])
                ],
            ])
            ->add('nameFact', TextType::class,[
                'label' => 'Nom du fait',
                'required' => true,
            ])
            ->add('descriptionFact', TextareaType::class,[
                'label' => 'Description du fait',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir une description !'])
                ],
            ])
            ->add('isValidated', ChoiceType::class, [
                'label' => 'Est validé',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'required' => true,
                'empty_data' => false,
            ])
            ->add('milestoneFact', EntityType::class,[
                'label' => 'Jalon concerné',
                'class' => Milestone::class,
                'query_builder' => function (MilestoneRepository $er) {
                    return $er->createQueryBuilder('cl')
                        ->orderBy('cl.id', 'ASC');
                },
                'choice_label' => 'nameMilestone',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir un jalon !'])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fact::class,
            'attr' => ['id' => 'factForm']
        ]);
    }
}

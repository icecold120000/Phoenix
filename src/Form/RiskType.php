<?php

namespace App\Form;

use App\Entity\Risk;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class RiskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameRisk', TextType::class,[
                'label' => 'Nom du risque',
                'required' => true,
            ])
            ->add('identificationDateRisk', DateType::class, [
                'label' => 'Date d\'identification du risque',
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'invalid_message' => 'Votre saisie n\'est pas une date !',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir une raison valable!'])
                ],
            ])
            ->add('resolutionDateRisk', DateType::class, [
                'label' => 'Date de résolution du risque',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('severityRisk', ChoiceType::class, [
                'label' => 'Sévérité du risque',
                'choices' => [
                    'Mineur' => 'Mineur',
                    'Sévère' => 'Sévère',
                    'Majeur' => 'Majeur',
                    'Critique' => 'Critique',
                ],
                'required' => true,
            ])
            ->add('probabilityRisk', NumberType::class,[
                'label' => 'Probabilité du risque',
                'help' => 'Saisir un nombre',
                'required' => true,
                'invalid_message' => 'Veuillez saisir un nombre !',
                'constraints' => [
                    new Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Veuillez saisir un nombre entre 0 et 100',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Risk::class,
            'attr' => ['id' => 'riskForm']
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Budget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('initialBudget', NumberType::class,[
                'label' => 'Budget initial',
                'invalid_message' => 'Veuillez saisir un nombre !',
                'required' => true,
                'constraints' => [
                    new Regex([
                        'match' => false,
                        'pattern' => "/[\-]/",
                        'message' => "Veuillez saisir un nombre positif !",
                    ])
                ],
            ])
            ->add('budgetUsed', NumberType::class,[
                'label' => 'Budget consommé',
                'invalid_message' => 'Veuillez saisir un nombre !',
                'required' => true,
                'constraints' => [
                    new Regex([
                        'match' => false,
                        'pattern' => "/[\-]/",
                        'message' => "Veuillez saisir un nombre positif !",
                    ])
                ],
            ])
            ->add('quantityLeftBudget', NumberType::class,[
                'label' => 'Budget reste à faire',
                'invalid_message' => 'Veuillez saisir un nombre !',
                'required' => true,
                'constraints' => [
                    new Regex([
                        'match' => false,
                        'pattern' => "/[\-]/",
                        'message' => "Veuillez saisir un nombre positif !",
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
            'attr' => ['id' => 'budgetForm']
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom du statut',
                'required' => true,
            ])
            ->add('slug', TextType::class,[
                'label' => 'Slug du statut',
                'required' => true,
            ])
            ->add('value', TextType::class,[
                'label' => 'Valeur du statut',
                'required' => true,
            ])
            ->add('colorStatus', ColorType::class,[
                'label' => 'Couleur du statut',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
            'attr' => ['id' => 'statusForm']
        ]);
    }
}

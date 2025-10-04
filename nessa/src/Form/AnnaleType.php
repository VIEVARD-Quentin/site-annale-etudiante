<?php
// src/Form/AnnaleType.php

namespace App\Form;

use App\Entity\Annale;
use App\Entity\Formation;
use App\Entity\Niveau;
use App\Entity\Matiere;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'nom',
                'mapped' => false,
                'placeholder' => 'Sélectionnez une formation'
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nom',
                'mapped' => false,
                'placeholder' => 'Sélectionnez un niveau',
                'choices' => [],
            ])
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'nom',
                'mapped' => false,
                'placeholder' => 'Sélectionnez une matière',
                'choices' => [],
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un type',
                'choices' => [],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'annale'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annale::class,
        ]);
    }
}

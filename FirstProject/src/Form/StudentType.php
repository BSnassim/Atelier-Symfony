<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Club;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('classroom', EntityType::class, [
                'class'=>Classroom::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('club', EntityType::class, [
                'class'=>Club::class,
                'choice_label'=>'ref',
                'multiple'=>true,
                'expanded'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}

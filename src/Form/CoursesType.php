<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\Languages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CoursesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupId', ChoiceType::class, [
                'choices' => array_flip(Courses::$groups)
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control rounded-block',
                    'Placeholder' => 'Course item title (let empty if it isn\'t necessary)'
                ]
            ])
            ->add('language', EntityType::class, [
                'class' => Languages::class,
                'choice_label' => 'title',
            ])
            ->add('textBody', TextareaType::class, [
                'attr' => [
                    'class' => 'test-text-display'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Courses::class,
        ]);
    }
}

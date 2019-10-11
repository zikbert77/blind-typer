<?php

namespace App\Form;

use App\Entity\Texts;
use App\Entity\Languages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TextsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text_body', TextareaType::class, [
                'attr' => [
                    'class' => 'test-text-display'
                ]
            ])
            ->add('language', EntityType::class, [
                'class' => Languages::class,
                'choice_label' => 'title',
            ])
            ->add('is_checked', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Texts::class,
        ]);
    }
}

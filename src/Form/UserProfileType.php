<?php

namespace App\Form;

use App\Component\Keyboard;
use App\Entity\Languages;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('defaultKeyboard', ChoiceType::class, [
                'choices' => array_flip(Keyboard::KEYBOARD_TITLES)
            ])
            ->add('defaultLanguage', EntityType::class, [
                'class' => Languages::class,
                'choice_label' => 'title'
            ])
            ->add('interfaceLanguage', EntityType::class, [
                'class' => Languages::class,
                'choice_label' => 'title'
            ])
            ->add('showTooltips', ChoiceType::class, [
                'choices' => [
                    "No" => 0,
                    "Yes" => 1
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
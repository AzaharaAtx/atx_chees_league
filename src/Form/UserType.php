<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'constraints' => [
                    new notBlank([
                        'message' => 'Please enter a value'
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email'
                    ])
                ]
            ])

            ->add('roles', ChoiceType::class, ['choices' => [
                'User' => 'ROLE_USER',
                'User' => 'ROLE_ADMIN'
                ],
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('password', null, [
                'constraints' => [
                    new notBlank([
                        'message' => 'Please enter a value'
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 255,
                    ])
                ]
            ])

            ->add('jwt_token')
            ->add('last_name')
            ->add('full_name')
            ->add('username_in_chess')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlayerRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username_in_chess', null,
            [
                'constraints' => [
                    new notBlank([
                    'message' => 'Please enter nick name.'
                    ])
                ]
            ])

            ->add('phone')
            ->add('friend_link')
            ->add('soft_delete')
            ->add('last_seen')
            ->add('user')
            ->add('league')
            ->add('game')
            ->add('rounds')
            ->add('games')
            ->add('leagues')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}

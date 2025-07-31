<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=> 'Nombre',
                'attr'=> [
                    'placeholder' => 'Ingrese su nombre',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=> 'Apellido',
                'attr'=> [
                    'placeholder' => 'Ingrese su Apellido',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=> 'email',
                'attr'=> [
                    'placeholder' => 'Correo Electronico',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                ]
            ])
            ->add('password',PasswordType::class,[
                'label'=> 'password',
                'attr'=> [
                    'placeholder' => 'Ingrese su password',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

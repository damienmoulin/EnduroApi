<?php


namespace App\Form\Security;


use App\Domain\Authentication\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('lastname', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('email', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('address', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('zipcode', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('city', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('phone', TextType::class, [
                'constraints' => new NotNull()
            ])
            ->add('first_password', PasswordType::class, [
                'constraints' => new NotNull(),
                'mapped' => false
            ])
            ->add('second_password', PasswordType::class, [
                'constraints' => new NotNull(),
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}

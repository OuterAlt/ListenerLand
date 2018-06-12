<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: thoams.merlin@fidesio.com
 * Date: 12/06/2018
 * Time: 22:39
 */

namespace App\Forms\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthenticationType extends AbstractType
{
    const formName = 'login_form';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'lastUsername' => null
            )
        );
    }

    public function getBlockPrefix()
    {
        return AuthenticationType::formName;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                array(
                    'label' => 'Identifiant',
                    'data' => $options['lastUsername'],
                    'attr' => array(
                        'placeholder' => 'Votre identifiant ...'
                    )
                )
            )
            ->add(
                'password',
                PasswordType::class,
                array(
                    'label' => 'Mot de passe'
                )
            )
        ;
    }
}
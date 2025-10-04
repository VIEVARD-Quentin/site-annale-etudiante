<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('pseudo')
            ->add('universite')
            ->add('formation', ChoiceType::class, [
                'choices' => [
                    'Droit' => 'Droit',
                    'IAE' => 'IAE',
                    'Science-Technologies santé' => 'Science-Technologies santé',
                    'IUT' => 'IUT',
                    'Faculté de lettres langues arts et sciences humaines' => 'Faculté de lettres langues arts et sciences humaines',
                ],
                'placeholder' => 'Sélectionnez une formation',
            ])
            ->add('niveau', ChoiceType::class, [
                'choices' => [
                    'Licence' => 'Licence',
                    'Master' => 'Master',
                    'BUT' => 'BUT',
                ],
                'placeholder' => 'Sélectionnez un niveau',
            ])
            ->add('email')
            ->add('telephone')
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez confirmer votre mot de passe.',
                    ]),
                ],
            ]);

        // Vérifie que les deux mots de passe sont identiques
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $user = $form->getData();
            $password = $user->getPassword();
            $confirmPassword = $form->get('confirm_password')->getData();

            if ($password !== $confirmPassword) {
                $form->get('confirm_password')->addError(new FormError('Les mots de passes ne sont pas identiques'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

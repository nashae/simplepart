<?php

namespace App\Form;

use App\Entity\Users;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminUserEditType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, $this->getConfiguration('email', "modifier l'email de l'utilisateur"))
            ->add('userName', TextType::class, $this->getConfiguration("nom d'utilisateur", "modifier le pseudo de l'utilisateur"))
            ->add('roles', ChoiceType::class,[
                'choices' => [
                'utilisateur' => 'ROLE_USER',
                'auteur' => 'ROLE_AUTHOR',
                'moderateur' => 'ROLE_MODO',
                'administrateur' => 'ROLE_ADMIN'
                ],
                'multiple' => true,
                'label' => 'Rôles'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

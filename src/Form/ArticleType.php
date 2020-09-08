<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\ImageType;
use App\form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', 'Titre de l\'article'))
            ->add('subTitle', TextType::class, $this->getConfiguration('Sous-Titre', "Sous-titre de l'article"))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Image principale', 'Lien vers l\'image'))
            ->add('content', TextareaType::class, $this->getConfiguration('Contenu', "Contenu de l'article"))
            ->add('category',ChoiceType::class,[
                'choices'  => [
                    'international' => 'international',
                    'france' => 'france',
                    'economie' => 'economie',
                    'culture' => 'culture'
                ]])
            ->add('images', CollectionType::class,[
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            //->add('author')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

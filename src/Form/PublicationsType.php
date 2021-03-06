<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Publications;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            //->add('slug')
            ->add('contenu', CKEditorType::class)
            //->add('createdAt')
            //->add('updatedAt')
            ->add('featuredText', TextType::class)
            //->add('isActive')
            //->add('isPublished')
            //->add('isFavorit')
            ->add('categorie', EntityType::class, [
                'class' => Categories::class
            ])
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publications::class,
        ]);
    }
}

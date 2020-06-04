<?php

namespace App\Form;

use App\Entity\Belong;
use App\Entity\Session;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class BelongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration')
            ->add('session', EntityType::class,
            [
                'class' => Session::class ,
                'choice_label' => 'title',
                'multiple' => false,
                'query_builder' => function (EntityRepository $er) 
                {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.title', 'ASC');
                },
            ])
            ->add('module', EntityType::class,
            [
                'class' => Module::class ,
                'choice_label' => 'title',
                'multiple' => false,
                'query_builder' => function (EntityRepository $er) 
                {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.title', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Belong::class,
            'translation_domain' => 'forms'
        ]);
    }
}

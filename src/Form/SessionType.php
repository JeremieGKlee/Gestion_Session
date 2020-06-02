<?php

namespace App\Form;

use App\Entity\Session;

use App\Entity\Stagiaire;
use App\Entity\Belong;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('date_start', DateType::class,
            [
                'years' => range(date('Y'),date('Y')+1),
                'label' => 'Date de début',
                'format' => 'ddMMMMyyyy',
            ])
            ->add('date_end', DateType::class,
            [
                'years' => range(date('Y'),date('Y')+1),
                'label' => 'Date de fin',
                'format' => 'ddMMMMyyyy',
            ])
            ->add('space_available')
            ->add('stagiaires', EntityType::class,
            [
                'class' => Stagiaire::class ,
                'required'=> false,
                'choice_label' => 'lastname',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            'translation_domain' => 'forms'
        ]);
    }
}

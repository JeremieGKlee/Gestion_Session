<?php

namespace App\Form;

use App\Entity\Stagiaire;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('sexe', ChoiceType::class,
            [
                'choices'=> $this->getChoices()
            ])
            
            ->add('born', DateType::class,
            [
                'years' => range(date('Y'),date('Y')-70),
                'label' => 'Date de naissance',
                'format' => 'ddMMMMyyyy',
            ])
            ->add('town')
            ->add('email')
            ->add('phone')
            ->add('actif')
            ->add('imageFile', FileType::class,
            [
                'required' => false,
            ])
            ->add('sessions', EntityType::class,
            [
                'class' => Session::class ,
                'required'=> false,
                // 'choice_label' => function($info)
                // {
                //     if(!$info->getIsFull())
                //     {
                //         return $info->getTitle() . " ( " . $info->getDateStart()->format('d/m/Y'). " - " . $info->getDateEnd()->format('d/m/Y'). " ) " .
                //        " ( Reste " . $info->getReste(). " places ) ";
                       
                //     }
                //     else 
                //     {
                //         return $info == null;
                //     }
                // },
                'choices' => $options['sessions_dispo'],
                'multiple' => true,
                'expanded' =>true,
                'query_builder' => function (EntityRepository $er) 
                {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.title', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
        [
            'data_class' => Stagiaire::class,
            'translation_domain' => 'forms',
            'sessions_dispo' => null
        ]);
    }

    private function getChoices()
    {
        $choices = Stagiaire::SEXE;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
}

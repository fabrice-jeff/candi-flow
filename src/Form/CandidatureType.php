<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ]
            ])
            ->add('prenom',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ]
            ])
            ->add('nationalite',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ]
            ])
            ->add('sexe',ChoiceType::class, [
                'attr'  =>[
                    'class'  => 'form-control'
                ],
                'choices'=> [
                    'Femme'=> 'F',
                    'Homme' => 'H'
                ]
            ])
            ->add('contact',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ],

            ])
            ->add('email',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ]
            ])
            ->add('dateNaissance',TextType::class, [
                'attr'  =>[
                    'class'  => 'form-control'
                ],
                'mapped' => false
            ])
            ->add('domaine',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ]
            ])
            ->add('niveauEtude',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ]
            ])
            ->add('formationPoste',null, [
                'attr'  =>[
                    'class'  => 'form-control'
                ],
                'mapped' => false,
                'label' => 'Formation en lien avec le poste'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}

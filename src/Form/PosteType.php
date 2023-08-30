<?php

namespace App\Form;

use App\Entity\Poste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', null,[
                'attr' =>[
                    'class' => 'form-control'
                ],
                'label' => "Nom du poste",
                'required' => false
            ])
            ->add('age',null,[
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder' => "Entrer l'age"
                ],
                'label' => false,
                'required' => false
            ])
            ->add('dateFin',null,[
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder' => "Date de fin"
                ],
                'label' => false,
                'required' => false
            ])
            ->add('niveauEtude',null,[
                'attr' =>[
                    'class' => 'form-control form-select select2',
                ],
                'label' => false,
                'placeholder' => "Sélectionner un niveau d'étude",
                'required' => false
            ])
            ->add('domaine',null,[
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder' => "Entrer le domaine"
                ],
                'label' => false,
                'required' => false
            ])
            ->add('nombreFormation',null,[
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder' => "Entrer le nombre de formation"
                ],
                'label' => false,
                'required' => false
            ])
            ->add('logicielSpecifique',null,[
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder' => "Entrer le nom du logiciel spécifique"
                ],
                'label' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
        ]);
    }
}

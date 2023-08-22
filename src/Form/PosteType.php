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
                ]
            ])
            ->add('description',null,[
                'attr' =>[
                    'class' => 'form-control'
                ]
            ])
            ->add('ageExige',null,[
                'attr' =>[
                    'class' => 'form-control'
                ]
            ])
            ->add('anneeExperiance',null,[
                'attr' =>[
                    'class' => 'form-control'
                ]
            ])
            ->add('outilInformatique',null,[
                'attr' =>[
                    'class' => 'form-control'
                ]
            ])
            ->add('atoutLangue', null,[
                'attr' =>[
                    'class' => 'form-control'
                ]
            ])
            ->add('atoutExperiance',null,[
                'attr' =>[
                    'class' => 'form-control'
                ]
            ])
            ->add('niveauEtude',null,[
                'attr' =>[
                    'class' => 'form-control select_simple'
                ],
                'placeholder' => "Sélectionner un niveau d'étude"

            ])
            ->add('domaine',null,[
                'attr' =>[
                    'class' => 'form-control select_simple'
                ],
                'placeholder' => "Sélectionner un domaine de formation"

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

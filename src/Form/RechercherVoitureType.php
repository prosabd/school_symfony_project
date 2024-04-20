<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\RechercherVoiture;
use App\Repository\VoitureRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercherVoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anneeMin', NumberType::class, ['row_attr' => ['class' => 'col-6 mb-2 ']])
            ->add('anneeMax', NumberType::class, ['row_attr' => ['class' => 'col-6 mb-2']])
            ->add('rechercher', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mb-2'],]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RechercherVoiture::class,
        ]);
    }
}

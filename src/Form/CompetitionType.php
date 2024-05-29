<?php

namespace App\Form;

use App\Entity\Competition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('datedebut')
            ->add('datefin')
            ->add('image', FileType::class, [
                'label' => 'Image  ',
                'required' => false, // Allow the form to be submitted without uploading a new image
                'mapped' => false, // This field is not mapped to the entity property
                'help' => 'Téléchargez une image pour le restaurant (format: jpg, jpeg, png)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}

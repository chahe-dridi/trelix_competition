<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('telephone')
            ->add('email')
            ->add('mdp')
            ->add('sexe',ChoiceType::class,[
                'choices'=>[
                    'Homme'=>'homme',
                    'Femme'=>'femme'
                ]
            ])
            ->add('domaine')
            ->add('niveau')
            ->add('specialite')
            ->add('role',ChoiceType::class,[
                'choices'=>[
                    'Étudiant'=>'Etudiant',
                    'Enseigant'=>'enseignant'
                ]
            ])
            ->add('Inscrire',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('datenaissance', 
            DateType::class, ['widget'=>'single_text'])
            ->add('telephone')
            ->add('email')
            ->add('service',EntityType::class,[
                'class'=> Service::class,
                'choice_label'=>'libelle',
            ])
           ->add('save',SubmitType::class,['label' => 'enregistre']) 
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('mission')
            ->add('adresseMail')
            ->add('entreprises', EntrepriseType::class)
            ->add('formations', EntityType::class, array(
              'class' => Formation::class,
              'choice_label' => 'nom',
              'multiple' => true,
              'expanded' => true,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}

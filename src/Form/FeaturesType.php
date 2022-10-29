<?php

namespace App\Form;

use App\Entity\Features;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeaturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vendre_boisson', CheckboxType::class, ['required' => false])
            ->add('gerer_planning', CheckboxType::class, ['required' => false])
            ->add('envoyer_newsletter', CheckboxType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Features::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\OfficeTbl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficeFormType extends AbstractType
{
    //builds a form to add an office
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('noOfOffices', IntegerType::class, array(
                'label' => 'Number of Offices',
                'mapped' => false
            ))
            ->add('officeSeats', IntegerType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OfficeTbl::class,
        ]);
    }
}

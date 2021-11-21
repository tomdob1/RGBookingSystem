<?php

namespace App\Form;

use App\Entity\EmployeeTbl;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingFormType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * form to build the booking page. Which displays radio buttons to select an hour or day - only if a whole day is available
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $schedule = $options['schedule']['schedule']; //schedule
        $wholeDay = $options['schedule']['wholeDayAvailable']; //boolean of whether the whole day is available

        if(!$wholeDay){ //if the whole day is not available - disable the 'Whole Day' option
            $builder->add('bookingLength', ChoiceType::class, [
                'choices' => [
                    'Whole Day' => 1,
                    'One Hour' => 0
                ],
                'choice_attr' => ['Whole Day' => ['disabled' => true ]],
                'data' => 0,
                'expanded' => true,
                'multiple' => false,
                'help'     => 'Full day not available to book'
            ]);
        }
        else{ //otherwise build with the option to select both radio buttons
            $builder->add('bookingLength', ChoiceType::class, [
                'choices' => [
                    'Whole Day' => 1,
                    'One Hour' => 0
                ],
                'row_attr' => [
                    'class' => 'day-input'
                ],
                'data' => 0,
                'expanded' => true,
                'multiple' => false,
            ]);
        }

        $builder
            ->add('email', EntityType::class, [
                'class' => EmployeeTbl::class,
                'choice_label' => 'email'
            ])
            ->add('time', ChoiceType::class, [
                'choices' => $schedule,
                'row_attr' => [
                    'class' => 'time-input'
                ],

            ])
            ->add('submit', SubmitType::class);

    }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                    'schedule' => null
            ));
        }





}

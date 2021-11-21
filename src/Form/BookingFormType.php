<?php

namespace App\Form;

use App\Entity\BookTbl;
use App\Entity\EmployeeTbl;
use App\Form\Model\SeatBookingFormModel;

use App\Repository\EmployeeTblRepository;
use App\Services\BookingValues;
use App\Services\Employee;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $schedule = $options['schedule']['schedule'];
        $wholeDay = $options['schedule']['wholeDayAvailable'];
        $bookingValue = new BookingValues();

        if(!$wholeDay){
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
        else{
            $builder->add('bookingLength', ChoiceType::class, [
                'choices' => [
                    'Whole Day' => 1,
                    'One Hour' => 0
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
                'attr' => array('class'=>'time-input')

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

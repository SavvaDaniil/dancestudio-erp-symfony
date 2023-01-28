<?php

namespace App\Form\Teacher;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

use App\DTO\Teacher\TeacherEditByColumnDTO;

class TeacherEditByColumnDTOForm extends AbstractType
{
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeacherEditByColumnDTO::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add("teacher_id", NumberType::class)
        ->add("value", TextType::class)
        ->add("name", TextType::class);
        //->add('submit', SubmitType::class)
    }
    
}
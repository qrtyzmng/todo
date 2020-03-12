<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TaskEditFormType extends AbstractType
{
    const NAME = 'name';
    const SUBMIT_NAME = 'save';
    const DONE_NAME = 'isDone';
    const NAME_LENGTH = 255;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder->add(static::NAME, TextType::class, array('constraints' => new NotBlank(), 'attr' => array('maxlength' => static::NAME_LENGTH)));
        $builder ->add(static::DONE_NAME, CheckboxType::class, ['label' => 'Done', 'required' => false]);
        $builder->add(static::SUBMIT_NAME, SubmitType::class);
    }
}

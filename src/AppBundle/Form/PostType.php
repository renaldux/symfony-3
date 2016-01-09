<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary', TextareaType::class)
            ->add('content', TextareaType::class)
            ->add('authorEmail', EmailType::class)
            ->add('publishedAt', DateTimeType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
        ;

        $builder->get('content')
            ->addModelTransformer(new CallbackTransformer(
                function($originalContent){
                    return preg_replace('#<br\s*/?>#i', '\n', $originalContent);
                },
                function($submittedContent){
                    $cleaned = strip_tags($submittedContent, '<br><p><h1>');
                    return str_replace('\n', '<br/>', $cleaned);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> 'AppBundle\Entity\Post'
        ]);
    }
}
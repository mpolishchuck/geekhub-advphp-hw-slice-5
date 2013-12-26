<?php

namespace PaulMaxwell\GuestbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'paul_maxwell_guestbook.post.name'))
            ->add('email', 'text', array('label' => 'paul_maxwell_guestbook.post.email'))
            ->add('messageBody', 'textarea', array('label' => 'paul_maxwell_guestbook.post.message'))
            ->add('post', 'submit', array('label' => 'paul_maxwell_guestbook.post.post'));
    }

    public function getName()
    {
        return 'post';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PaulMaxwell\GuestbookBundle\Entity\Message',
            'csrf_protection' => true,
        ));
    }
}

<?php

namespace AppBundle\Controller\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of CategoryType
 *
 * @author Mat
 */
class CategoryType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add( 'name',          TextType::class, array(
                                        'label' => 'form.label.name'
        ));
        $builder->add( 'description',   TextType::class, array(
                                        'label' => 'form.label.desc'
        ));
        $builder->add( 'parent',        EntityType::class, array(
                                        'label' => 'category.parent',
                                        'class' => 'AppBundle:Category',
                                        'choice_label' => 'name',
                                        'mapped' => false
        ));
        $builder->add( 'save',          SubmitType::class, array( 
                                        'label' => 'form.label.save' ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Category',
        ));
    }
}

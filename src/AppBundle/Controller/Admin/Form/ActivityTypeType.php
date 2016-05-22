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
class ActivityTypeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add( 'name',  TextType::class )
            ->add( 'commitments', EntityType::class,
                                    array(
                                        'required' => false,
                                        'multiple' => true,
                                        'expanded' => 'true',
                                        'class' => 'AppBundle:Commitment',
                                        'choice_label' => 'description',
                                        'label' => 'Lier un ou plusieurs engagements'
                                    ))
            ->add( 'save',  SubmitType::class, array( 'label' => 'form.label.save' ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ActivityType',
        ));
    }
}

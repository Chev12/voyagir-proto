<?php

namespace AppBundle\Controller\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Controller\Admin\Form\QuestionType;

/**
 * Description of CommitmentType
 *
 * @author Mat
 */
class CommitmentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add( 'description',TextType::class )
            ->add( 'icon',            TextType::class )
            ->add( 'save',            SubmitType::class, array( 'label' => 'save' ));
        $builder->add('questions', CollectionType::class, array(
            'entry_type'    => QuestionType::class,
            'allow_add'     => true,
            'allow_delete' => true,
            'by_reference' => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commitment',
        ));
    }
}

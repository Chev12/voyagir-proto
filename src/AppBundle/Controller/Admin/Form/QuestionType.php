<?php

namespace AppBundle\Controller\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
/**
 * Description of ActivityType
 *
 * @author Mat
 */
class QuestionType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add( 'level', IntegerType::class );
        $builder->add( 'type',  IntegerType::class );
        $builder->add( 'question',  TextType::class );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CommitmentQuestion',
        ));
    }
}

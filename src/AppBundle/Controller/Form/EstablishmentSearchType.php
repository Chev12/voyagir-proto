<?php

namespace AppBundle\Controller\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of EstablishmentSearchType
 *
 * @author Mat
 */
class EstablishmentSearchType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ( $options['locale'] === 'fr' )
        {
            $countryChoice = 'name_fr_fr';
        }
        else {
            $countryChoice = 'name_en_gb';
        }
        
        $builder->add( 'name',          TextType::class, array(
                                            'label' => 'form.label.name' ))
                ->add( 'category',      EntityType::class, array(
                                            'class' => 'AppBundle:Category',
                                            'choice_label' => 'name',
                                            'label' => 'form.label.category',
                                            'placeholder' => 'form.placeholder.category' ))
                ->add( 'adressRegion',  TextType::class, array(
                                            'label' => 'form.label.region' ))
                ->add( 'adressCity',    TextType::class, array(
                                            'label' => 'form.label.city' ))
                ->add( 'adressCountry', EntityType::class, array(
                                            'class' => 'AppBundle:Country',
                                            'choice_label' => $countryChoice,
                                            'label' => 'form.label.country',
                                            'placeholder' => 'form.placeholder.country'
                                            ))
                ->add( 'search',        SubmitType::class, array( 
                                            'label' => 'form.label.search' ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Establishment',
            'locale' => 'en',
            'required' => false
        ));
    }
}

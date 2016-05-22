<?php

namespace AppBundle\Controller\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of EstablishmentType
 *
 * @author Mat
 */
class EstablishmentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ( $options["locale"] === 'fr' )
        {
            $countryChoice = 'name_fr_fr';
        }
        else {
            $countryChoice = 'name_en_gb';
        }
        
        $builder->add( 'name',          TextType::class, array(
                                            'label' => 'form.label.name' ))
            ->add( 'description',       TextareaType::class, array(
                                            'label' => 'form.label.desc' ))
            ->add( 'category',          EntityType::class, array(
                                            'required' => false,
                                            'class' => 'AppBundle:Category',
                                            'choice_label' => 'name',
                                            'label' => 'form.label.category',
                                            'placeholder' => 'form.placeholder.category' ))
            ->add( 'usefulInfo',        TextareaType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.useful_info' ))
            ->add( 'customCommitments', TextareaType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.custom_commit'))
            ->add( 'adress',            TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.adress' ))
            ->add( 'adressRegion',      TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.region' ))
            ->add( 'adressCity',        TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.city' ))
            ->add( 'adressCountry',     EntityType::class, array(
                                            'class' => 'AppBundle:Country',
                                            'choice_label' => $countryChoice,
                                            'label' => 'form.label.country',
                                            'placeholder' => 'form.placeholder.country'
                                        ))
            ->add( 'coord',             TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.coord' ))
            ->add( 'imageFile',         FileType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.pic' ))
            ->add( 'imageOffset',       IntegerType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.pic_offset' ))
            ->add( 'contactMail',       TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.contact_mail' ))
            ->add( 'contactPhone',      TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.contact_phone' ))
            ->add( 'contactFb',         TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.contact_fb' ))
            ->add( 'contactTwt',        TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.contact_twt' ))
            ->add( 'contactWebsite',    TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.contact_website' ))
            ->add( 'imageName',         TextType::class, array(
                                            'required' => false,
                                            'label' => 'form.label.cur_pic', 
                                            'disabled' => true ))
            ->add( 'labels',            EntityType::class, array(
                                            'required' => false,
                                            'multiple' => true,
                                            'expanded' => 'true',
                                            'class' => 'AppBundle:Label',
                                            'choice_label' => 'name',
                                            'label' => 'establishment.manage.labels'
                                        ))
            ->add( 'save',              SubmitType::class, array( 
                                            'label' => 'form.label.save' ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Establishment',
            'locale' => 'en'
        ));
    }
}

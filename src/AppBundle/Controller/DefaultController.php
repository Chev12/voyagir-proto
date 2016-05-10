<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Establishment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Controller\Form\EstablishmentSearchType;

class DefaultController extends ControllerSpecial
{
    /**
     * @var \AppBundle\Services\Business\EstablishmentService
     */
    private $establishmentService;
    
    public function init(){
        $this->establishmentService = $this->getBusinessService ( 'Establishment' );
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $establishments = $this->establishmentService->findLastValidated(3);
        
        $form = $this->createForm ( EstablishmentSearchType::class, new Establishment(), 
                array ( 'action' => $this->generateUrl ( 'etb_search_form' )));
        //$form = $this->buildForm( new Establishment() );
        
        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
            'establishments' => $establishments
        ));
    }
    
    /**
     * Create the quick search form
     * @param Activity $establishment
     * @return Form
     */
    public function buildForm ( $establishment )
    {
        $locale = $this->get('request')->getLocale();
        if ( $locale === 'fr' )
        {
            $countryChoice = 'name_fr_fr';
        }
        else {
            $countryChoice = 'name_en_gb';
        }
        return $this->createFormBuilder ( $establishment )
                ->setAction($this->generateUrl('etb_search_form'))
                ->add( 'category',      EntityType::class, array(
                                            'class' => 'AppBundle:Category',
                                            'choice_label' => 'name',
                                            'placeholder' => 'form.label.category',
                                            'label' => false,
                                            'required' => false ))
                ->add( 'adressCity',    TextType::class, array(
                                            'label' => 'form.label.city',
                                            'required' => false ))
                ->add( 'adressCountry', EntityType::class, array(
                                            'class' => 'AppBundle:Country',
                                            'choice_label' => $countryChoice,
                                            'placeholder' => 'form.label.country',
                                            'label' => false,
                                            'required' => false
                                            ))
                ->add( 'search',        SubmitType::class, array( 
                                            'label' => 'form.label.search' ))
                ->getForm();
    }
}


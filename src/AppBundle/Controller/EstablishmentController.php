<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Establishment;

class EstablishmentController extends ControllerSpecial
{
    /**
     * @var \AppBundle\Services\Business\EstablishmentService
     */
    private $establishmentService;
    
    public function init(){
        $this->establishmentService = 
                $this->get( 'app.business_service_factory' )
                     ->build( 'Establishment' );
    }
    
    /**
     * @Route("/etb/{_id}", name="etb_detail")
     */
    public function indexAction( $_id = 0 )
    {   
        $establishment = $this->establishmentService->get( $_id );
        
        return $this->render('establishment/detail.html.twig', array(
            'establishment' => $establishment,
            'activities' => $establishment->getActivities()
        ));
    }
    
    /**
     * @Route("/manage/etb/{_id}", name="etb_manage_update",
     *                            defaults={"_id" = 0})
     * @Route("/manage/etb/", name="etb_manage_create",
     *                      defaults={"_id" = 0})
     */
    public function manageAction ( Request $request, $_id = 0 )
    {
        // Getting an existing establishment or a new one
        $establishment = $this->getEstablishment ( $_id );
        // Verify that the user has access to the establishment
        if( $_id != 0 ) {
            $this->denyAccessUnlessGranted ( 'edit', $establishment );
        }
        
        // Creating form
        $form = $this->buildForm ( $establishment );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $establishment = $this->establishmentService->save( $establishment );
            return  $this->redirect(
                        $this->generateUrl('etb_detail').'/'.$establishment->getId()
                    );
        }
        
        // Show form
        return $this->render( 'establishment/manage.html.twig', array(
            'form' => $form->createView(),
            'establishment' => $establishment,
            'activities' => $establishment->getActivities()
        ));
    }
    
    /**
     * Create the estbalishment form
     * @param Establishment $establishment
     * @return Form
     */
    function buildForm ( $establishment )
    {
        $save_label = $this->get( 'translator' )->trans( "establishment.manage.save" );
        $form = $this->createFormBuilder($establishment)
            ->add( 'name',       TextType::class )
            ->add( 'description',TextType::class )
            ->add( 'adress',     TextType::class )
            ->add( 'save',       SubmitType::class, array( 'label' => $save_label ))
            ->getForm();
        return $form;
    }
    
    /**
     * @Route("delete/etb", name="etb_manage_delete")
     */
    public function delete( Request $request ){
        $this->get('logger')->info('lol');
        if($request->getMethod( "POST" )){
            $id = $request->get( "idEtb" );
            $establishment = $this->establishmentService->get( $id );
            // Verify that the user has access to the establishment
            $this->denyAccessUnlessGranted( 'edit', $establishment );
            $this->establishmentService->remove( $establishment );
        }
        
        return $this->redirectToRoute( 'homepage' );
    }
    
    /**
     * Finds the establishment with the given id or creates a new one.
     * @param type $_id Establishment ID : use 0 to create a new one
     * @return Establishment
     * @throws type NotFoundException
     */
    public function getEstablishment($_id){
        if($_id != 0){
            $establishment = $this->establishmentService->get( $_id );
        }
        // Creating a new one
        else{
            $establishment = new Establishment();
            $establishment->setIdUserOwner($this->getUser());
        }
        return $establishment;
    }
}


<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Form\EstablishmentType;
use AppBundle\Controller\Form\EstablishmentSearchType;
use AppBundle\Entity\Establishment;

class EstablishmentController extends ControllerSpecial
{
    /**
     * @var \AppBundle\Services\Business\EstablishmentService
     */
    private $establishmentService;
    
    public function init(){
        $this->establishmentService = $this->getBusinessService( 'Establishment' );
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
        $form = $this->createForm(EstablishmentType::class, $establishment);
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
     * @Route("/search/etb/", name="etb_search_form")
     */
    public function searchAction ( Request $request )
    {
        $etbCriteria = new Establishment();
        // Creating form
        $form = $this->createForm ( EstablishmentSearchType::class, $etbCriteria );
        $form->handleRequest ( $request );

        // Search
        if ( $form->isValid() ) {
            $establishments = $this->establishmentService->search( $etbCriteria );
            return $this->render( 'establishment/results.html.twig', array(
                'establishments' => $establishments
            ));
        }
        
        // Show form
        return $this->render( 'establishment/search.html.twig', array(
            'form' => $form->createView(),
            'establishment' => $etbCriteria
        ));
    }
    
    /**
     * @Route("delete/etb", name="etb_manage_delete")
     */
    public function deleteAction( Request $request ){
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
     * @Route("validate/etb", name="etb_admin_validate")
     */
    public function validateAction( Request $request ){
        if($request->getMethod( "POST" )){
            $id = $request->get( "idEtb" );
            $establishment = $this->establishmentService->get( $id );
            $this->establishmentService->validate( $establishment );
        }
        
        return $this->redirectToRoute( 'admin_home' );
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
            $establishment->setUserOwner($this->getUser());
        }
        return $establishment;
    }
}


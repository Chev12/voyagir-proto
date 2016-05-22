<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Admin\Form\LabelType;
use AppBundle\Controller\ControllerSpecial;
use AppBundle\Entity\Label;

/**
 * Description of LabelController
 *
 * @author Mat
 */
class LabelController extends ControllerSpecial {
    
    /**
     * @var AppBundle\Services\Business\LabelService
     */
    private $labelService;
    
    public function init(){
        $this->labelService = $this->getBusinessService ( 'Label' );
    }
    
    /**
     * @Route("/admin/label/{_id}", name="lbl_admin_update",
     *                            defaults={"_id" = 0})
     * @Route("/admin/label/", name="lbl_admin_create",
     *                      defaults={"_id" = 0})
     */
    public function adminAction ( Request $request, $_id = 0 )
    {
        // Getting an existing label or a new one
        $label = $this->getLabel ( $_id );
        
        // Creating form
        $form = $this->createForm ( LabelType::class, $label );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $label = $this->labelService->save( $label );
            return $this->forward('AppBundle:Admin\Admin:index');
        }
        
        // Show form
        return $this->render( 'admin/basicAdmin.html.twig', array(
            'object_name' => 'Controller',
            'form' => $form->createView(),
            'label' => $label
        ));
    }
    
    /**
     * @Route("admin/delete/lbl", name="lbl_admin_delete")
     */
    public function deleteAction( Request $request ){
        if($request->getMethod( "POST" )){
            $id = $request->get( "idLbl" );
            $label = $this->labelService->get( $id );
            $this->commitmentService->remove( $label );
        }
        
        return $this->redirectToRoute( 'admin_home' );
    }
    
    /**
     * Finds the label with the given id or creates a new one.
     * @param type $_id Label ID : use 0 to create a new one
     * @return Label
     * @throws type NotFoundException
     */
    public function getLabel($_id){
        if($_id != 0){
            $label = $this->labelService->get( $_id );
        }
        // Creating a new one
        else{
            $label = new Label();
        }
        return $label;
    }
}

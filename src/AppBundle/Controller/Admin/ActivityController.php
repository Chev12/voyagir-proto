<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Admin\Form\ActivityTypeType;
use AppBundle\Controller\ControllerSpecial;
use AppBundle\Entity\ActivityType;

/**
 * Description of ActivityController
 *
 * @author Mat
 */
class ActivityController extends ControllerSpecial {
    
    /**
     * @var AppBundle\Services\Business\ActivityTypeService
     */
    private $activityService;
    
    public function init(){
        $this->activityService = $this->getBusinessService ( 'ActivityType' );
    }
    
    /**
     * @Route("/admin/activity/{_id}", name="act_admin_update",
     *                            defaults={"_id" = 0})
     * @Route("/admin/activity/", name="act_admin_create",
     *                      defaults={"_id" = 0})
     */
    public function adminAction ( Request $request, $_id = 0 )
    {
        // Getting an existing activity or a new one
        $activity = $this->getActivity ( $_id );
        
        // Creating form
        $form = $this->createForm ( ActivityTypeType::class, $activity );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $activity = $this->activityService->save( $activity );
            return $this->forward('AppBundle:Admin\Admin:index');
        }
        
        // Show form
        return $this->render( 'admin/activity.html.twig', array(
            'object_name' => 'Activity',
            'form' => $form->createView(),
            'activity' => $activity
        ));
    }
    
    /**
     * @Route("admin/delete/act", name="act_admin_delete")
     */
    public function deleteAction( Request $request ){
        if($request->getMethod( "POST" )){
            $id = $request->get( "idAct" );
            $activity = $this->activityService->get( $id );
            $this->activityService->remove( $activity );
        }
        
        return $this->redirectToRoute( 'admin_home' );
    }
    
    /**
     * Finds the activity with the given id or creates a new one.
     * @param type $_id Establishment ID : use 0 to create a new one
     * @return Activity
     * @throws type NotFoundException
     */
    public function getActivity($_id){
        if($_id != 0){
            $activity = $this->activityService->get( $_id );
        }
        // Creating a new one
        else{
            $activity = new ActivityType();
        }
        return $activity;
    }
}
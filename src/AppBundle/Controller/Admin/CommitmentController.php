<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\ControllerSpecial;
use AppBundle\Entity\Commitment;
use AppBundle\Controller\Admin\Form\CommitmentType;

/**
 * Description of CommitmentController
 *
 * @author Mat
 */
class CommitmentController extends ControllerSpecial {
    
    /**
     * @var AppBundle\Services\Business\CommitmentService
     */
    private $commitmentService;
    
    public function init(){
        $this->commitmentService = $this->getBusinessService ( 'Commitment' );
    }
    
    /**
     * @Route("/admin/commitment/{_id}", name="cmt_admin_update",
     *                            defaults={"_id" = 0})
     * @Route("/admin/commitment/", name="cmt_admin_create",
     *                      defaults={"_id" = 0})
     */
    public function adminAction ( Request $request, $_id = 0 )
    {
        // Getting an existing commitment or a new one
        $commitment = $this->getCommitment ( $_id );
        
        // Creating form
        $form = $this->buildForm ( $commitment );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $commitment = $this->commitmentService->save( $commitment );
            return $this->forward('AppBundle:Admin\Admin:index');
        }
        
        // Show form
        return $this->render( 'admin/commitment/manage.html.twig', array(
            'form' => $form->createView(),
            'commitment' => $commitment
        ));
    }
    
    /**
     * Create the commitment form
     * @param Commitment $commitment
     * @return Form
     */
    function buildForm ( $commitment )
    {
        $save_label = $this->get( 'translator' )->trans( "establishment.manage.save" );
        return $this->createForm(CommitmentType::class, $commitment);
    }
    
    /**
     * @Route("delete/cmt", name="cmt_admin_delete")
     */
    public function deleteAction( Request $request ){
        if($request->getMethod( "POST" )){
            $id = $request->get( "idCmt" );
            $activity = $this->commitmentService->get( $id );
            $this->commitmentService->remove( $activity );
        }
        
        return $this->redirectToRoute( 'admin_home' );
    }
    
    /**
     * Finds the commitment with the given id or creates a new one.
     * @param type $_id Establishment ID : use 0 to create a new one
     * @return Commitment
     * @throws type NotFoundException
     */
    public function getCommitment($_id){
        if($_id != 0){
            $commitment = $this->commitmentService->get( $_id );
        }
        // Creating a new one
        else{
            $commitment = new Commitment();
        }
        return $commitment;
    }
}
